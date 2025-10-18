<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidatoController extends Controller
{
    public function index()
    {
        $candidatos = Candidato::all();
        return view('candidatos.index', compact('candidatos'));
    }

    public function create()
    {
        return view('candidatos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'partido' => 'nullable|string|max:255',
            'color_hex' => 'required|string|max:7',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'propuesta' => 'nullable|string',
            'activo' => 'boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('candidatos', 'public');
        }

        Candidato::create($data);

        return redirect()->route('candidatos.index')
            ->with('success', 'Candidato creado exitosamente.');
    }

    public function show(Candidato $candidato)
    {
        $candidato->load(['resultados.mesa.recinto.localidad.municipio.provincia.departamento']);
        return view('candidatos.show', compact('candidato'));
    }

    public function edit(Candidato $candidato)
    {
        return view('candidatos.edit', compact('candidato'));
    }

    public function update(Request $request, Candidato $candidato)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'partido' => 'nullable|string|max:255',
            'color_hex' => 'required|string|max:7',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'propuesta' => 'nullable|string',
            'activo' => 'boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($candidato->foto) {
                Storage::disk('public')->delete($candidato->foto);
            }
            $data['foto'] = $request->file('foto')->store('candidatos', 'public');
        }

        $candidato->update($data);

        return redirect()->route('candidatos.index')
            ->with('success', 'Candidato actualizado exitosamente.');
    }

    public function destroy(Candidato $candidato)
    {
        // Eliminar foto si existe
        if ($candidato->foto) {
            Storage::disk('public')->delete($candidato->foto);
        }

        $candidato->delete();

        return redirect()->route('candidatos.index')
            ->with('success', 'Candidato eliminado exitosamente.');
    }
}