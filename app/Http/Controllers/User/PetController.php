<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Especie;
use App\Models\AdoptionRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Este controlador permite a los usuarios ver mascotas disponibles para adopción, solicitar adopciones y gestionar sus solicitudes.
class PetController extends Controller
{
    /**
     * Muestra el listado de mascotas disponibles para adopción
     */
    public function index(Request $request)
    {
        $type = $request->get('type');
        $gender = $request->get('gender');
        
        $pets = Pet::where('status', 'available')
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($gender, function ($query, $gender) {
                return $query->where('gender', $gender);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        
        return view('user.pets.index', compact('pets', 'type', 'gender'));
    }

    /**
     * Muestra los detalles de una mascota específica
     */
    public function show(Pet $pet)
    {
        return view('user.pets.show', compact('pet'));
    }

    /**
     * Muestra el formulario para solicitar la adopción
     */
    public function adoptionForm(Pet $pet)
    {
        $user = Auth::user();
        return view('user.pets.adoption-form', compact('pet', 'user'));
    }

    /**
     * Guarda una nueva solicitud de adopción.
     */
    public function submitAdoption(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'dni' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|min:10',
        ]);
        
        // Evita solicitudes duplicadas pendientes para la misma mascota por el mismo usuario:
        $existingRequest = AdoptionRequest::where('user_id', Auth::id())
            ->where('pet_id', $pet->id)
            ->where('status', 'pending')
            ->first();
            
        if ($existingRequest) {
            return redirect()->back()->with('error', 'Ya tienes una solicitud pendiente para esta mascota.');
        }
        
        // Crea la solicitud
        AdoptionRequest::create([
            'user_id' => Auth::id(),
            'pet_id' => $pet->id,
            'message' => $validated['message'],
            'status' => 'pending',
            'admin_notes' => null,
        ]);
        
        // Actualiza el usuario con los datos de adopción
        $user = User::find(Auth::id());
        $user->dni = $validated['dni'];
        $user->phone = $validated['phone'];
        $user->save();
        
        // Cambia el estado de la mascota a pending
        $pet->status = 'pending';
        $pet->save();
        
        return redirect()->route('user.pets.index')->with('success', 'Tu solicitud de adopción ha sido enviada y será evaluada por un administrador.');
    }
}
