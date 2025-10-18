<?php

namespace App\Http\Controllers;

use App\Models\Provincia;
use App\Models\Departamento;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
     public function index()
    {
        // SOLUCIÓN: No uses withCount para mesas, usa el atributo calculado
        $provincias = Provincia::with(['departamento'])
            ->withCount(['municipios']) // Esto sí funciona
            ->get()
            ->each(function ($provincia) {
                // Agregar el count de mesas manualmente usando el atributo calculado
                $provincia->mesas_count = $provincia->total_mesas;
            });
        
        return view('provincias.index', compact('provincias'));
    }

    public function create()
    {
        $departamentos = Departamento::all();
        return view('provincias.create', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'departamento_id' => 'required|exists:departamentos,id',
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:provincias,codigo',
            'total_inscritos' => 'required|integer|min:0'
        ]);

        Provincia::create($request->all());

        return redirect()->route('provincias.index')
            ->with('success', 'Provincia creada exitosamente.');
    }

    public function show(Provincia $provincia)
    {
        $provincia->load(['departamento', 'municipios.localidades.recintos.mesas']);
        return view('provincias.show', compact('provincia'));
    }

    public function edit(Provincia $provincia)
    {
        $departamentos = Departamento::all();
        return view('provincias.edit', compact('provincia', 'departamentos'));
    }

    public function update(Request $request, Provincia $provincia)
    {
        $request->validate([
            'departamento_id' => 'required|exists:departamentos,id',
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:provincias,codigo,' . $provincia->id,
            'total_inscritos' => 'required|integer|min:0'
        ]);

        $provincia->update($request->all());

        return redirect()->route('provincias.index')
            ->with('success', 'Provincia actualizada exitosamente.');
    }

    public function destroy(Provincia $provincia)
    {
        $provincia->delete();

        return redirect()->route('provincias.index')
            ->with('success', 'Provincia eliminada exitosamente.');
    }

    public function getByDepartamento($departamentoId)
    {
        $provincias = Provincia::where('departamento_id', $departamentoId)->get();
        return response()->json($provincias);
    }
}