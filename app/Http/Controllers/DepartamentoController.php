<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        // SOLUCIÓN: No uses withCount para mesas, usa el atributo calculado
        $departamentos = Departamento::withCount(['provincias'])
            ->get()
            ->each(function ($departamento) {
                $departamento->mesas_count = $departamento->total_mesas;
            });
        
        return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        return view('departamentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:departamentos,codigo',
            'total_inscritos' => 'required|integer|min:0'
        ]);

        Departamento::create($request->all());

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento creado exitosamente.');
    }

    public function show(Departamento $departamento)
    {
        $departamento->load(['provincias.municipios.localidades.recintos.mesas']);
        return view('departamentos.show', compact('departamento'));
    }

    public function edit(Departamento $departamento)
    {
        return view('departamentos.edit', compact('departamento'));
    }

    public function update(Request $request, Departamento $departamento)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:departamentos,codigo,' . $departamento->id,
            'total_inscritos' => 'required|integer|min:0'
        ]);

        $departamento->update($request->all());

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento actualizado exitosamente.');
    }

    public function destroy(Departamento $departamento)
    {
        $departamento->delete();

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento eliminado exitosamente.');
    }
}