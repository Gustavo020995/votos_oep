<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\Recinto;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    public function index()
    {
        $mesas = Mesa::with(['recinto.localidad.municipio.provincia.departamento'])->get();
        return view('mesas.index', compact('mesas'));
    }

    public function create()
    {
        $recintos = Recinto::with('localidad.municipio.provincia.departamento')->get();
        return view('mesas.create', compact('recintos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recinto_id' => 'required|exists:recintos,id',
            'numero_mesa' => 'required|string|max:50',
            'codigo_mesa' => 'required|string|unique:mesas,codigo_mesa',
            'total_inscritos' => 'required|integer|min:0'
        ]);

        Mesa::create($request->all());

        return redirect()->route('mesas.index')
            ->with('success', 'Mesa creada exitosamente.');
    }

    public function show(Mesa $mesa)
    {
        $mesa->load([
            'recinto.localidad.municipio.provincia.departamento',
            'resultados.candidato',
            'votosEspeciales.tipoVoto'
        ]);
        return view('mesas.show', compact('mesa'));
    }

    public function edit(Mesa $mesa)
    {
        $recintos = Recinto::with('localidad.municipio.provincia.departamento')->get();
        return view('mesas.edit', compact('mesa', 'recintos'));
    }

    public function update(Request $request, Mesa $mesa)
    {
        $request->validate([
            'recinto_id' => 'required|exists:recintos,id',
            'numero_mesa' => 'required|string|max:50',
            'codigo_mesa' => 'required|string|unique:mesas,codigo_mesa,' . $mesa->id,
            'total_inscritos' => 'required|integer|min:0',
            'estado' => 'required|in:pendiente,conteo_en_proceso,conteo_finalizado'
        ]);

        $mesa->update($request->all());

        return redirect()->route('mesas.index')
            ->with('success', 'Mesa actualizada exitosamente.');
    }

    public function destroy(Mesa $mesa)
    {
        $mesa->delete();

        return redirect()->route('mesas.index')
            ->with('success', 'Mesa eliminada exitosamente.');
    }

    public function getByRecinto($recintoId)
    {
        $mesas = Mesa::where('recinto_id', $recintoId)->get();
        return response()->json($mesas);
    }
}