<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Raza; // Agregar import
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
        $translated = [
            'perro' => 'dog',
            'gato' => 'cat',
            'otro' => 'other',
        ];

        $searchTranslated = strtolower($search);
        $typeSearch = $translated[$searchTranslated] ?? $search;

        $pets = Pet::with('raza') // Cargar la relación
            ->when($search, function ($query) use ($typeSearch) {
                $query->where('name', 'like', "%{$typeSearch}%")
                    ->orWhere('type', 'like', "%{$typeSearch}%")
                    ->orWhereHas('raza', function($q) use ($typeSearch) {
                        $q->where('nombre', 'like', "%{$typeSearch}%");
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
        $razas = Raza::orderBy('especie')->orderBy('nombre')->get();
        return view('admin.pet.create', compact('razas'));
    }

    /**
     * Guarda una nueva mascota en la base de datos con validación y subida opcional de imagen.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:255',
            'type' => 'required|in:dog,cat',
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
            'type.required' => 'La especie es requerida',
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
            'type' => $validated['type'],
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
        $razas = Raza::orderBy('especie')->orderBy('nombre')->get();
        $pet->load('raza'); // Cargar la relación
        return view('admin.pet.edit', compact('pet', 'razas'));
    }

    /**
     * Actualiza los datos de una mascota. Similar al método store 
     */
    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:255',
            'type' => 'required|in:dog,cat',
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
            'type.required' => 'La especie es requerida',
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
            'type' => $validated['type'],
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
     * Método para obtener razas por especie (AJAX)
     */
    public function getRazasByEspecie(Request $request)
    {
        $type = $request->get('type');
        
        // Convertir de inglés a español
        $especieEspanol = match($type) {
            'dog' => 'Perro',
            'cat' => 'Gato',
            default => null
        };
        
        if (!$especieEspanol) {
            return response()->json([]);
        }
        
        $razas = Raza::where('especie', $especieEspanol)
                    ->orderBy('nombre')
                    ->get(['id', 'nombre']);
        
        return response()->json($razas);
    }
}