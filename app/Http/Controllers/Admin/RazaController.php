<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Raza;
use Illuminate\Http\Request;

class RazaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $razas = Raza::when($search, function ($query, $search) {
            return $query->where('nombre', 'like', "%{$search}%")
                        ->orWhere('especie', 'like', "%{$search}%");
        })
        ->orderBy('especie')
        ->orderBy('nombre')
        ->paginate(10);

        return view('admin.razas.index', compact('razas', 'search'));
    }

    public function create()
    {
        return view('admin.razas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|in:Perro,Gato',
            'descripcion' => 'required|string'
        ]);

        Raza::create($request->all());

        return redirect()->route('admin.razas.index')
                        ->with('success', 'Raza creada exitosamente.');
    }

    public function edit(Raza $raza)
    {
        return view('admin.razas.edit', compact('raza'));
    }

    public function update(Request $request, Raza $raza)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|in:Perro,Gato',
            'descripcion' => 'required|string'
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