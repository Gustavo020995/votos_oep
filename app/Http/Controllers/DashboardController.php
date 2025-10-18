<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Mesa;
use App\Models\Candidato;
use App\Models\Resultado;
use App\Models\VotoEspecial;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Filtros
        $departamentoId = $request->get('departamento');
        $provinciaId = $request->get('provincia');
        $municipioId = $request->get('municipio');
        $localidadId = $request->get('localidad');
        $recintoId = $request->get('recinto');
        $mesaId = $request->get('mesa');

        // Obtener datos geográficos
        $departamentos = Departamento::all();
        
        // Obtener mesas con filtros
        $mesasQuery = Mesa::with(['recinto.localidad.municipio.provincia.departamento', 'resultados']);
        
        if ($departamentoId) {
            $mesasQuery->whereHas('recinto.localidad.municipio.provincia', function($q) use ($departamentoId) {
                $q->where('departamento_id', $departamentoId);
            });
        }
        
        // Aplicar más filtros según sea necesario...
        
        $mesas = $mesasQuery->get();

        // Obtener candidatos
        $candidatos = Candidato::where('activo', true)->get();

        // Estadísticas generales OEP
        $totalMesas = Mesa::count();
        $mesasEscrutadas = Mesa::where('estado', 'conteo_finalizado')->count();
        $porcentajeEscrutado = $totalMesas > 0 ? round(($mesasEscrutadas / $totalMesas) * 100, 2) : 0;

        $totalVotosValidos = Resultado::sum('votos');
        $totalVotosBlancos = VotoEspecial::whereHas('tipoVoto', function($q) {
            $q->where('codigo', 'blanco');
        })->sum('cantidad');
        $totalVotosNulos = VotoEspecial::whereHas('tipoVoto', function($q) {
            $q->where('codigo', 'nulo');
        })->sum('cantidad');

        $totalVotosEmitidos = $totalVotosValidos + $totalVotosBlancos + $totalVotosNulos;
        $totalInscritos = Mesa::sum('total_inscritos');
        $participacion = $totalInscritos > 0 ? round(($totalVotosEmitidos / $totalInscritos) * 100, 2) : 0;

        $estadisticasGenerales = [
            'total_mesas' => $totalMesas,
            'mesas_escrutadas' => $mesasEscrutadas,
            'porcentaje_escrutado' => $porcentajeEscrutado,
            'votos_validos' => $totalVotosValidos,
            'votos_blancos' => $totalVotosBlancos,
            'votos_nulos' => $totalVotosNulos,
            'votos_emitidos' => $totalVotosEmitidos,
            'total_inscritos' => $totalInscritos,
            'participacion' => $participacion,
            'abstencion' => $totalInscritos - $totalVotosEmitidos,
        ];

        return view('dashboard.index', compact(
            'departamentos',
            'mesas', 
            'candidatos', 
            'estadisticasGenerales'
        ));
    }
}