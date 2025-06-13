<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $pets = Pet::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('breed', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('admin.pet.index', compact('pets', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pet.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:255',
            'type' => 'required|in:dog,cat,other',
            'breed' => 'required|min:2|max:255',
            'age' => 'required|integer|min:0|max:20',
            'size' => 'required|in:small,medium,large',
            'gender' => 'required|in:male,female',
            'description' => 'required|min:10',
            'photo' => 'nullable|image|max:2048', // 2MB max
            'is_vaccinated' => 'boolean',
            'is_sterilized' => 'boolean',
        ], [
            'name.required' => 'El nombre es requerido',
            'name.min' => 'El nombre debe tener al menos 2 caracteres',
            'type.required' => 'La especie es requerida',
            'breed.required' => 'La raza es requerida',
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
            'breed' => $validated['breed'],
            'age' => $validated['age'],
            'size' => $validated['size'],
            'gender' => $validated['gender'],
            'description' => $validated['description'],
            'status' => 'available',
            'is_vaccinated' => $request->has('is_vaccinated'),
            'is_sterilized' => $request->has('is_sterilized'),
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('pets', 'public');
            $data['images'] = [$photoPath];
        }

        Pet::create($data);

        return redirect()->route('admin.pet.index')
            ->with('success', 'Mascota creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        return view('admin.pet.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        return view('admin.pet.edit', compact('pet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:255',
            'type' => 'required|in:dog,cat,other',
            'breed' => 'required|min:2|max:255',
            'age' => 'required|integer|min:0|max:20',
            'size' => 'required|in:small,medium,large',
            'gender' => 'required|in:male,female',
            'description' => 'required|min:10',
            'status' => 'required|in:available,adopted,pending',
            'photo' => 'nullable|image|max:2048', // 2MB max
            'is_vaccinated' => 'boolean',
            'is_sterilized' => 'boolean',
        ], [
            'name.required' => 'El nombre es requerido',
            'name.min' => 'El nombre debe tener al menos 2 caracteres',
            'type.required' => 'La especie es requerida',
            'breed.required' => 'La raza es requerida',
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
            'breed' => $validated['breed'],
            'age' => $validated['age'],
            'size' => $validated['size'],
            'gender' => $validated['gender'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'is_vaccinated' => $request->has('is_vaccinated'),
            'is_sterilized' => $request->has('is_sterilized'),
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($pet->images && count($pet->images) > 0) {
                Storage::disk('public')->delete($pet->images[0]);
            }
            
            $photoPath = $request->file('photo')->store('pets', 'public');
            $data['images'] = [$photoPath];
        }

        $pet->update($data);

        return redirect()->route('admin.pet.index')
            ->with('success', 'Mascota actualizada exitosamente.');
    }
}
