<?php

namespace App\Http\Controllers;

use App\Models\Recinto;
use App\Models\Localidad;
use Illuminate\Http\Request;

class RecintoController extends Controller
{
    public function index()
    {
        $recintos = Recinto::with(['localidad.municipio.provincia.departamento'])->withCount(['mesas'])->get();
        return view('recintos.index', compact('recintos'));
    }

    public function create()
    {
        $localidades = Localidad::with('municipio.provincia.departamento')->get();
        return view('recintos.create', compact('localidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'localidad_id' => 'required|exists:localidades,id',
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:recintos,codigo',
            'direccion' => 'nullable|string|max:500',
            'total_inscritos' => 'required|integer|min:0'
        ]);

        Recinto::create($request->all());

        return redirect()->route('recintos.index')
            ->with('success', 'Recinto creado exitosamente.');
    }

    public function show(Recinto $recinto)
    {
        $recinto->load(['localidad.municipio.provincia.departamento', 'mesas']);
        return view('recintos.show', compact('recinto'));
    }

    public function edit(Recinto $recinto)
    {
        $localidades = Localidad::with('municipio.provincia.departamento')->get();
        return view('recintos.edit', compact('recinto', 'localidades'));
    }

    public function update(Request $request, Recinto $recinto)
    {
        $request->validate([
            'localidad_id' => 'required|exists:localidades,id',
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:recintos,codigo,' . $recinto->id,
            'direccion' => 'nullable|string|max:500',
            'total_inscritos' => 'required|integer|min:0'
        ]);

        $recinto->update($request->all());

        return redirect()->route('recintos.index')
            ->with('success', 'Recinto actualizado exitosamente.');
    }

    public function destroy(Recinto $recinto)
    {
        $recinto->delete();

        return redirect()->route('recintos.index')
            ->with('success', 'Recinto eliminado exitosamente.');
    }

    public function getByLocalidad($localidadId)
    {
        $recintos = Recinto::where('localidad_id', $localidadId)->get();
        return response()->json($recintos);
    }
}