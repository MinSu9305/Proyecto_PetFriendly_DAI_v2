<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Raza; 
use App\Models\Especie; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    /**
     * Lista las mascotas con opción de búsqueda
     */
public function index(Request $request)
{
    $search = $request->get('search');
    
    // Traducción ampliada con más términos comunes
    $translated = [
        'perro' => 'dog', 'canino' => 'dog', 'can' => 'dog',
        'gato' => 'cat', 'felino' => 'cat', 'gat' => 'cat',
        'conejo' => 'rabbit', 'rabbit' => 'rabbit',
        'ave' => 'bird', 'pájaro' => 'bird',
        'otro' => 'other', 'otros' => 'other'
    ];

    $normalizedSearch = trim(strtolower($search));
    $typeSearch = $translated[$normalizedSearch] ?? $search;

    $pets = Pet::with(['raza', 'especie'])
        ->when($search, function ($query) use ($typeSearch, $normalizedSearch, $search) {
            $query->where(function($q) use ($typeSearch, $normalizedSearch, $search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$typeSearch}%")
                  ->orWhere('type', 'like', "%{$normalizedSearch}%")
                  ->orWhereHas('raza', function($q) use ($search) {
                      $q->where('nombre', 'like', "%{$search}%");
                  })
                  ->orWhereHas('especie', function($q) use ($search) {
                      $q->where('nombre', 'like', "%{$search}%");
                  });
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(5);

    return view('admin.pet.index', compact('pets', 'search'));
}
    /**
     * Muestra el formulario para registrar una nueva mascota.
     */
public function create()
{
    $especies = Especie::orderBy('nombre')->get();
    return view('admin.pet.create', compact('especies'));
}

    /**
     * Guarda una nueva mascota en la base de datos con validación y subida opcional de imagen.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:255',
            'especie_id' => 'required|exists:especies,id', // Cambiar de type a especie_id
            'raza_id' => 'required|exists:razas,id', // Cambiado de breed a raza_id
            'age' => 'required|integer|min:0|max:20',
            'size' => 'required|in:small,medium,large',
            'gender' => 'required|in:male,female',
            'description' => 'required|min:10',
            'photo' => 'nullable|image|max:2048',
            //'is_vaccinated' => 'boolean',
            //'is_sterilized' => 'boolean',
        ], [
            'name.required' => 'El nombre es requerido',
            'name.min' => 'El nombre debe tener al menos 2 caracteres',
            'especie_id.required' => 'La especie es requerida',
            'raza_id.required' => 'La raza es requerida',
            'raza_id.exists' => 'La raza seleccionada no es válida',
            'age.required' => 'La edad es requerida',
            'age.integer' => 'La edad debe ser un número',
            'age.min' => 'La edad no puede ser negativa',
            'age.max' => 'La edad no puede ser mayor a 20 años',
            'size.required' => 'El tamaño es requerido',
            'gender.required' => 'El sexo es requerido',
            'description.required' => 'La descripción es requerida',
            'description.min' => 'La descripción debe tener al menos 10 caracteres',
            'photo.image' => 'El archivo debe ser una imagen',
            'photo.max' => 'La imagen no puede ser mayor a 2MB',
        ]);

        $data = [
            'name' => $validated['name'],
            'especie_id' => $validated['especie_id'],
            'raza_id' => $validated['raza_id'], // Cambiado de breed a raza_id
            'age' => $validated['age'],
            'size' => $validated['size'],
            'gender' => $validated['gender'],
            'description' => $validated['description'],
            'status' => 'available',
            //'is_vaccinated' => $request->has('is_vaccinated'),
            //'is_sterilized' => $request->has('is_sterilized'),
        ];

        // Si hay foto
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('pets', 'public');
            $data['images'] = [$photoPath];
        }

        Pet::create($data);

        return redirect()->route('admin.pets.index')
            ->with('success', 'Mascota creada exitosamente.');
    }

    /**
     * Muestra los detalles individuales de una mascota específica.
     */
    public function show(Pet $pet)
    {
        $pet->load('raza'); // Cargar la relación
        return view('admin.pet.show', compact('pet'));
    }

    /**
     * Muestra el formulario para editar una mascota
     */
public function edit(Pet $pet)
{
    $especies = Especie::orderBy('nombre')->get();
    
    return view('admin.pet.edit', compact('pet', 'especies'));
}
   /**
     * Actualiza los datos de una mascota. Similar al método store 
     */
    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:255',
            'especie_id' => 'required|exists:especies,id',
            'raza_id' => 'required|exists:razas,id', // Cambiado de breed a raza_id
            'age' => 'required|integer|min:0|max:20',
            'size' => 'required|in:small,medium,large',
            'gender' => 'required|in:male,female',
            'description' => 'required|min:10',
            'status' => 'required|in:available,adopted,pending',
            'photo' => 'nullable|image|max:2048',
            //'is_vaccinated' => 'boolean',
            //'is_sterilized' => 'boolean',
        ], [
            'name.required' => 'El nombre es requerido',
            'name.min' => 'El nombre debe tener al menos 2 caracteres',
            'especie_id.required' => 'La especie es requerida',
            'raza_id.required' => 'La raza es requerida',
            'raza_id.exists' => 'La raza seleccionada no es válida',
            'age.required' => 'La edad es requerida',
            'age.integer' => 'La edad debe ser un número',
            'age.min' => 'La edad no puede ser negativa',
            'age.max' => 'La edad no puede ser mayor a 20 años',
            'size.required' => 'El tamaño es requerido',
            'gender.required' => 'El sexo es requerido',
            'description.required' => 'La descripción es requerida',
            'description.min' => 'La descripción debe tener al menos 10 caracteres',
            'status.required' => 'El estado es requerido',
            'photo.image' => 'El archivo debe ser una imagen',
            'photo.max' => 'La imagen no puede ser mayor a 2MB',
        ]);

        $data = [
            'name' => $validated['name'],
            'especie_id' => $validated['especie_id'],
            'raza_id' => $validated['raza_id'], // Cambiado de breed a raza_id
            'age' => $validated['age'],
            'size' => $validated['size'],
            'gender' => $validated['gender'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            //'is_vaccinated' => $request->has('is_vaccinated'),
            //'is_sterilized' => $request->has('is_sterilized'),
        ];

        if ($request->hasFile('photo')) {
            if ($pet->images && count($pet->images) > 0) {
                Storage::disk('public')->delete($pet->images[0]);
            }

            $photoPath = $request->file('photo')->store('pets', 'public');
            $data['images'] = [$photoPath];
        }

        $pet->update($data);

        return redirect()->route('admin.pets.index')
            ->with('success', 'Mascota actualizada exitosamente.');
    }

/**
 * Obtener razas por especie (para AJAX)
 */
public function getRazasByEspecie(Request $request)
{
    try {
        $especie_id = $request->get('especie_id');
        
        if (!$especie_id) {
            return response()->json([]);
        }
        
        $razas = Raza::where('especie_id', $especie_id)
                    ->orderBy('nombre')
                    ->get(['id', 'nombre']);
        
        return response()->json($razas);
    } catch (\Exception $e) {
        return response()->json([], 500);
    }
}
}