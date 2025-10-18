<?php

namespace App\Http\Controllers;

use App\Models\Resultado;
use App\Models\Mesa;
use App\Models\Candidato;
use App\Models\TipoVoto;
use App\Models\VotoEspecial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResultadoController extends Controller
{
    public function index()
{
 // Obtener todos los resultados con relaciones (menos eficiente pero funciona)
    $resultados = Resultado::with([
            'mesa.recinto.localidad.municipio.provincia.departamento', 
            'candidato'
        ])
        ->get();

    // Agrupar manualmente por número de acta
    $actasAgrupadas = $resultados->groupBy('numero_acta')->map(function($grupoActa) {
        $primerRegistro = $grupoActa->first();
        $primerRegistro->total_votos_acta = $grupoActa->sum('votos');
        $primerRegistro->cantidad_registros = $grupoActa->count();
        return $primerRegistro;
    });

    // Paginar manualmente
    $page = request()->get('page', 1);
    $perPage = 20;
    $actas = new \Illuminate\Pagination\LengthAwarePaginator(
        $actasAgrupadas->forPage($page, $perPage)->values(),
        $actasAgrupadas->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    $totalActas = $actasAgrupadas->count();
    $actasAprobadas = $actasAgrupadas->where('estado_acta', 'aprobada')->count();
    $actasPendientes = $actasAgrupadas->where('estado_acta', 'pendiente')->count();
    $actasObservadas = $actasAgrupadas->where('estado_acta', 'observada')->count();

    return view('resultados.index', compact('actas', 'totalActas', 'actasAprobadas', 'actasPendientes', 'actasObservadas'));}

    public function create()
    {
        $mesas = Mesa::with('recinto.localidad.municipio.provincia.departamento')
            ->where('estado', '!=', 'conteo_finalizado')
            ->get();
        $candidatos = Candidato::where('activo', true)->get();
        $tiposVotos = TipoVoto::where('activo', true)->get();

        if ($mesas->count() === 0) {
            return redirect()->route('resultados.index')
                ->with('error', 'No hay mesas disponibles para registrar resultados.');
        }

        return view('resultados.create', compact('mesas', 'candidatos', 'tiposVotos'));
    }

   public function store(Request $request)
{
    \Log::info('=== INICIANDO STORE ===');
    \Log::info('Datos recibidos:', $request->all());

    // Validación
    $request->validate([
        'mesa_id' => 'required|exists:mesas,id',
        'votos' => 'required|array',
        'votos.*' => 'required|integer|min:0',
        'votos_especiales' => 'required|array',
        'votos_especiales.*' => 'required|integer|min:0',
        'foto_acta' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'numero_acta' => 'required|string|max:100',
        'fecha_acta' => 'required|date',
    ]);

    \Log::info('Validación pasada');

    try {
        \DB::beginTransaction();
        \Log::info('Transacción iniciada');

        $mesaId = $request->mesa_id;
        $fotoActaPath = null;

        \Log::info("Mesa ID: " . $mesaId);
        \Log::info("Votos recibidos: " . json_encode($request->votos));
        \Log::info("Votos especiales recibidos: " . json_encode($request->votos_especiales));

        if ($request->hasFile('foto_acta')) {
            $fotoActaPath = $request->file('foto_acta')->store('actas', 'public');
            \Log::info("Foto guardada en: " . $fotoActaPath);
        }

        // Procesar votos por candidato
        foreach ($request->votos as $candidatoId => $cantidadVotos) {
            \Log::info("Procesando candidato $candidatoId: $cantidadVotos votos");
            
            if ($cantidadVotos > 0) {
                $resultado = Resultado::updateOrCreate(
                    [
                        'mesa_id' => $mesaId,
                        'candidato_id' => $candidatoId
                    ],
                    [
                        'votos' => $cantidadVotos,
                        'foto_acta' => $fotoActaPath,
                        'numero_acta' => $request->numero_acta,
                        'fecha_acta' => $request->fecha_acta,
                        'estado_acta' => 'pendiente'
                    ]
                );
                \Log::info("Resultado guardado ID: " . $resultado->id);
            } else {
                $deleted = Resultado::where('mesa_id', $mesaId)
                    ->where('candidato_id', $candidatoId)
                    ->delete();
                \Log::info("Resultados eliminados: " . $deleted);
            }
        }

        // Procesar votos especiales
        foreach ($request->votos_especiales as $tipoVotoId => $cantidad) {
            \Log::info("Procesando tipo voto $tipoVotoId: $cantidad votos");
            
            if ($cantidad >= 0) {
                $votoEspecial = VotoEspecial::updateOrCreate(
                    [
                        'mesa_id' => $mesaId,
                        'tipo_voto_id' => $tipoVotoId
                    ],
                    ['cantidad' => $cantidad]
                );
                \Log::info("Voto especial guardado ID: " . $votoEspecial->id);
            }
        }

        // Actualizar estado de la mesa
        $mesa = Mesa::find($mesaId);
        $totalVotos = array_sum($request->votos) + array_sum($request->votos_especiales);
        
        \Log::info("Total votos: $totalVotos, Estado anterior: " . $mesa->estado);
        
        if ($totalVotos > 0) {
            $mesa->update(['estado' => 'conteo_en_proceso']);
            \Log::info("Mesa actualizada a: conteo_en_proceso");
        }

        \DB::commit();
        \Log::info("Transacción completada");

        return redirect()->route('resultados.index')
            ->with('success', 'Acta registrada exitosamente.');

    } catch (\Exception $e) {
        \DB::rollBack();
        \Log::error('Error al registrar acta: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        
        return redirect()->back()
            ->with('error', 'Error al registrar el acta: ' . $e->getMessage())
            ->withInput();
    }
}
    public function edit($mesaId)
    {
        $mesa = Mesa::with([
            'recinto.localidad.municipio.provincia.departamento',
            'resultados.candidato',
            'votosEspeciales.tipoVoto'
        ])->findOrFail($mesaId);

        $candidatos = Candidato::where('activo', true)->get();
        $tiposVotos = TipoVoto::where('activo', true)->get();

        $resultadosExistentes = $mesa->resultados->pluck('votos', 'candidato_id')->toArray();
        $votosEspecialesExistentes = $mesa->votosEspeciales->pluck('cantidad', 'tipo_voto_id')->toArray();

        $actaData = $mesa->resultados->first();

        return view('resultados.edit', compact(
            'mesa',
            'candidatos',
            'tiposVotos',
            'resultadosExistentes',
            'votosEspecialesExistentes',
            'actaData'
        ));
    }

    public function update(Request $request, $mesaId)
    {
        $request->validate([
            'votos' => 'required|array',
            'votos.*' => 'required|integer|min:0',
            'votos_especiales' => 'required|array',
            'votos_especiales.*' => 'required|integer|min:0',
            'foto_acta' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'numero_acta' => 'required|string|max:100',
            'fecha_acta' => 'required|date',
        ]);

        try {
            \DB::beginTransaction();

            $fotoActaPath = null;

            if ($request->hasFile('foto_acta')) {
                $fotoActaPath = $request->file('foto_acta')->store('actas', 'public');
            }

            // Procesar votos por candidato
            foreach ($request->votos as $candidatoId => $cantidadVotos) {
                if ($cantidadVotos > 0) {
                    $resultado = Resultado::where('mesa_id', $mesaId)
                        ->where('candidato_id', $candidatoId)
                        ->first();

                    if ($resultado) {
                        $updateData = ['votos' => $cantidadVotos];
                        if ($fotoActaPath) {
                            // Eliminar foto anterior si existe
                            if ($resultado->foto_acta) {
                                Storage::disk('public')->delete($resultado->foto_acta);
                            }
                            $updateData['foto_acta'] = $fotoActaPath;
                        }
                        $resultado->update($updateData);
                    } else {
                        Resultado::create([
                            'mesa_id' => $mesaId,
                            'candidato_id' => $candidatoId,
                            'votos' => $cantidadVotos,
                            'foto_acta' => $fotoActaPath,
                            'numero_acta' => $request->numero_acta,
                            'fecha_acta' => $request->fecha_acta,
                            'estado_acta' => 'pendiente'
                        ]);
                    }
                } else {
                    Resultado::where('mesa_id', $mesaId)
                        ->where('candidato_id', $candidatoId)
                        ->delete();
                }
            }

            // Procesar votos especiales
            foreach ($request->votos_especiales as $tipoVotoId => $cantidad) {
                VotoEspecial::updateOrCreate(
                    [
                        'mesa_id' => $mesaId,
                        'tipo_voto_id' => $tipoVotoId
                    ],
                    ['cantidad' => $cantidad]
                );
            }

            // Actualizar estado de la mesa
            $mesa = Mesa::find($mesaId);
            $totalVotos = array_sum($request->votos) + array_sum($request->votos_especiales);
            
            if ($totalVotos >= $mesa->total_inscritos) {
                $mesa->update(['estado' => 'conteo_finalizado']);
            } else if ($totalVotos > 0) {
                $mesa->update(['estado' => 'conteo_en_proceso']);
            }

            \DB::commit();

            return redirect()->route('resultados.index')
                ->with('success', 'Acta actualizada exitosamente.');

        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar el acta: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updateEstadoActa(Request $request, Resultado $resultado)
    {
        $request->validate([
            'estado_acta' => 'required|in:pendiente,aprobada,rechazada,observada',
            'observaciones' => 'nullable|string|max:500'
        ]);

        // Actualizar todos los resultados con el mismo número de acta
        Resultado::where('numero_acta', $resultado->numero_acta)
            ->update([
                'estado_acta' => $request->estado_acta,
                'observaciones' => $request->observaciones
            ]);

        return redirect()->back()
            ->with('success', 'Estado del acta actualizado exitosamente.');
    }

    public function destroy(Resultado $resultado)
    {
        // Eliminar todos los resultados con el mismo número de acta
        $numeroActa = $resultado->numero_acta;
        
        // Eliminar fotos de actas si existen
        $actas = Resultado::where('numero_acta', $numeroActa)->get();
        foreach ($actas as $acta) {
            if ($acta->foto_acta) {
                Storage::disk('public')->delete($acta->foto_acta);
            }
        }

        Resultado::where('numero_acta', $numeroActa)->delete();

        return redirect()->route('resultados.index')
            ->with('success', 'Acta eliminada exitosamente.');
    }
}