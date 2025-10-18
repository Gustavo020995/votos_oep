<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use App\Models\Municipio;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    public function index()
    {
        $localidades = Localidad::with(['municipio.provincia.departamento'])->withCount(['recintos', 'mesas'])->get();
        return view('localidades.index', compact('localidades'));
    }

    public function create()
    {
        $municipios = Municipio::with('provincia.departamento')->get();
        return view('localidades.create', compact('municipios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'municipio_id' => 'required|exists:municipios,id',
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:localidades,codigo',
            'total_inscritos' => 'required|integer|min:0'
        ]);

        Localidad::create($request->all());

        return redirect()->route('localidades.index')
            ->with('success', 'Localidad creada exitosamente.');
    }

    public function show(Localidad $localidad)
    {
        $localidad->load(['municipio.provincia.departamento', 'recintos.mesas']);
        return view('localidades.show', compact('localidad'));
    }

    public function edit(Localidad $localidad)
    {
        $municipios = Municipio::with('provincia.departamento')->get();
        return view('localidades.edit', compact('localidad', 'municipios'));
    }

    public function update(Request $request, Localidad $localidad)
    {
        $request->validate([
            'municipio_id' => 'required|exists:municipios,id',
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:localidades,codigo,' . $localidad->id,
            'total_inscritos' => 'required|integer|min:0'
        ]);

        $localidad->update($request->all());

        return redirect()->route('localidades.index')
            ->with('success', 'Localidad actualizada exitosamente.');
    }

    public function destroy(Localidad $localidad)
    {
        $localidad->delete();

        return redirect()->route('localidades.index')
            ->with('success', 'Localidad eliminada exitosamente.');
    }

    public function getByMunicipio($municipioId)
    {
        $localidades = Localidad::where('municipio_id', $municipioId)->get();
        return response()->json($localidades);
    }
}