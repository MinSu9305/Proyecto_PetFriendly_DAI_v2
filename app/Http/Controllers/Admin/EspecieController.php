<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Especie;
use Illuminate\Http\Request;

class EspecieController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $especies = Especie::when($search, function ($query, $search) {
            return $query->where('nombre', 'like', "%{$search}%");
        })
        ->withCount('razas', 'mascotas') // Contar razas y mascotas relacionadas
        ->orderBy('nombre')
        ->paginate(10);

        return view('admin.especies.index', compact('especies', 'search'));
    }

    public function create()
    {
        return view('admin.especies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:especies,nombre',
            'descripcion' => 'required|string'
        ], [
            'nombre.required' => 'El nombre de la especie es requerido',
            'nombre.unique' => 'Esta especie ya existe',
            'descripcion.required' => 'La descripción es requerida'
        ]);

        Especie::create($request->all());

        return redirect()->route('admin.especies.index')
                        ->with('success', 'Especie creada exitosamente.');
    }

    public function edit(Especie $especie)
    {
        return view('admin.especies.edit', compact('especie'));
    }

    public function update(Request $request, Especie $especie)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:especies,nombre,' . $especie->id,
            'descripcion' => 'required|string'
        ], [
            'nombre.required' => 'El nombre de la especie es requerido',
            'nombre.unique' => 'Esta especie ya existe',
            'descripcion.required' => 'La descripción es requerida'
        ]);

        $especie->update($request->all());

        return redirect()->route('admin.especies.index')
                        ->with('success', 'Especie actualizada exitosamente.');
    }

    public function destroy(Especie $especie)
    {
        // Verificar si tiene razas o mascotas asociadas
        if ($especie->razas()->count() > 0 || $especie->mascotas()->count() > 0) {
            return redirect()->route('admin.especies.index')
                            ->with('error', 'No se puede eliminar la especie porque tiene razas o mascotas asociadas.');
        }

        $especie->delete();

        return redirect()->route('admin.especies.index')
                        ->with('success', 'Especie eliminada exitosamente.');
    }
}