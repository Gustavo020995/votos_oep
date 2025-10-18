<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use App\Models\Provincia;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
      public function index()
    {
        // SOLUCIÓN: No uses withCount para mesas, usa el atributo calculado
        $municipios = Municipio::with(['provincia.departamento'])
            ->withCount(['localidades']) // Esto sí funciona
            ->get()
            ->each(function ($municipio) {
                // Agregar el count de mesas manualmente usando el atributo calculado
                $municipio->mesas_count = $municipio->total_mesas;
            });
        
        return view('municipios.index', compact('municipios'));
    }

    public function create()
    {
        $provincias = Provincia::with('departamento')->get();
        return view('municipios.create', compact('provincias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'provincia_id' => 'required|exists:provincias,id',
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:municipios,codigo',
            'total_inscritos' => 'required|integer|min:0'
        ]);

        Municipio::create($request->all());

        return redirect()->route('municipios.index')
            ->with('success', 'Municipio creado exitosamente.');
    }

    public function show(Municipio $municipio)
    {
        $municipio->load(['provincia.departamento', 'localidades.recintos.mesas']);
        return view('municipios.show', compact('municipio'));
    }

    public function edit(Municipio $municipio)
    {
        $provincias = Provincia::with('departamento')->get();
        return view('municipios.edit', compact('municipio', 'provincias'));
    }

    public function update(Request $request, Municipio $municipio)
    {
        $request->validate([
            'provincia_id' => 'required|exists:provincias,id',
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:municipios,codigo,' . $municipio->id,
            'total_inscritos' => 'required|integer|min:0'
        ]);

        $municipio->update($request->all());

        return redirect()->route('municipios.index')
            ->with('success', 'Municipio actualizado exitosamente.');
    }

    public function destroy(Municipio $municipio)
    {
        $municipio->delete();

        return redirect()->route('municipios.index')
            ->with('success', 'Municipio eliminado exitosamente.');
    }

    public function getByProvincia($provinciaId)
    {
        $municipios = Municipio::where('provincia_id', $provinciaId)->get();
        return response()->json($municipios);
    }
}