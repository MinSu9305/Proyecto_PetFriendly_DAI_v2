<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Raza;
use App\Models\Especie;
use Illuminate\Http\Request;

class RazaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $razas = Raza::with('especie') 
            ->when($search, function ($query, $search) {
                return $query->where('nombre', 'like', "%{$search}%")
                            ->orWhereHas('especie', function($q) use ($search) {
                                $q->where('nombre', 'like', "%{$search}%");
                            });
            })
            ->orderBy('nombre')
            ->paginate(10);

        return view('admin.razas.index', compact('razas', 'search'));
    }

    public function create()
    {
        $especies = Especie::orderBy('nombre')->get(); // Obtener todas las especies
        return view('admin.razas.create', compact('especies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'especie_id' => 'required|exists:especies,id', // Cambiar validación
            'descripcion' => 'required|string'
        ], [
            'nombre.required' => 'El nombre de la raza es requerido',
            'especie_id.required' => 'La especie es requerida',
            'especie_id.exists' => 'La especie seleccionada no es válida',
            'descripcion.required' => 'La descripción es requerida'
        ]);

        Raza::create($request->all());

        return redirect()->route('admin.razas.index')
                        ->with('success', 'Raza creada exitosamente.');
    }

    public function edit(Raza $raza)
    {
        $especies = Especie::orderBy('nombre')->get(); // Obtener todas las especies
        $raza->load('especie'); // Cargar relación
        return view('admin.razas.edit', compact('raza', 'especies'));
    }

    public function update(Request $request, Raza $raza)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'especie_id' => 'required|exists:especies,id', // Cambiar validación
            'descripcion' => 'required|string'
        ], [
            'nombre.required' => 'El nombre de la raza es requerido',
            'especie_id.required' => 'La especie es requerida',
            'especie_id.exists' => 'La especie seleccionada no es válida',
            'descripcion.required' => 'La descripción es requerida'
        ]);

        $raza->update($request->all());

        return redirect()->route('admin.razas.index')
                        ->with('success', 'Raza actualizada exitosamente.');
    }

    public function destroy(Raza $raza)
    {
        $raza->delete();

        return redirect()->route('admin.razas.index')
                        ->with('success', 'Raza eliminada exitosamente.');
    }
}