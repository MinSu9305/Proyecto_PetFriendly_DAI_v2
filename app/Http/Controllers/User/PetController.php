<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Especie;
use App\Models\AdoptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    public function index(Request $request)
    {
        // *** OBTENER LAS ESPECIES PARA EL FILTRO ***
        $especies = Especie::orderBy('nombre')->get();
        
        // *** CAMBIAR DE 'type' A 'especie_id' ***
        $especieId = $request->get('especie_id');
        $gender = $request->get('gender');

        // Construir la consulta
        $query = Pet::with(['especie', 'raza'])
            ->where('status', 'available');

        // *** FILTRAR POR ESPECIE_ID EN LUGAR DE TYPE ***
        if ($especieId) {
            $query->where('especie_id', $especieId);
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        $pets = $query->orderBy('created_at', 'desc')->paginate(12);

        // *** PASAR LAS ESPECIES A LA VISTA ***
        return view('user.pets.index', compact('pets', 'especies', 'especieId', 'gender'));
    }

    public function show(Pet $pet)
    {
        // Cargar las relaciones necesarias
        $pet->load(['especie', 'raza']);
        
        // *** AGREGAR LA VARIABLE USER ***
        $user = Auth::user();
        
        return view('user.pets.show', compact('pet', 'user'));
    }

    public function adoptionForm(Pet $pet)
    {
        // Verificar que la mascota esté disponible
        if ($pet->status !== 'available') {
            return redirect()->route('user.pets.index')
                ->with('error', 'Esta mascota ya no está disponible para adopción.');
        }

        // *** AGREGAR LA VARIABLE USER TAMBIÉN AQUÍ ***
        $user = Auth::user();
        
        return view('user.pets.adoption-form', compact('pet', 'user'));
    }

    public function submitAdoption(Request $request, Pet $pet)
    {
        // Validar que la mascota esté disponible
        if ($pet->status !== 'available') {
            return redirect()->route('user.pets.index')
                ->with('error', 'Esta mascota ya no está disponible para adopción.');
        }

        // Verificar que el usuario no tenga una solicitud pendiente para esta mascota
        $existingRequest = AdoptionRequest::where('user_id', Auth::id())
            ->where('pet_id', $pet->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingRequest) {
            return redirect()->route('user.pets.show', $pet)
                ->with('error', 'Ya tienes una solicitud de adopción para esta mascota.');
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Crear la solicitud de adopción
        AdoptionRequest::create([
            'user_id' => Auth::id(),
            'pet_id' => $pet->id,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return redirect()->route('user.pets.show', $pet)
            ->with('success', 'Tu solicitud de adopción ha sido enviada correctamente.');
    }
}
