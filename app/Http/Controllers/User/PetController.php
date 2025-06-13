<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\AdoptionRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    /**
     * Display a listing of available pets.
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
            ->paginate(8);
        
        return view('user.pets.index', compact('pets', 'type', 'gender'));
    }

    /**
     * Display the specified pet.
     */
    public function show(Pet $pet)
    {
        return view('user.pets.show', compact('pet'));
    }

    /**
     * Show the form for creating a new adoption request.
     */
    public function adoptionForm(Pet $pet)
    {
        $user = Auth::user();
        return view('user.pets.adoption-form', compact('pet', 'user'));
    }

    /**
     * Store a newly created adoption request.
     */
    public function submitAdoption(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'dni' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|min:10',
        ]);
        
        // Check if user already has a pending request for this pet
        $existingRequest = AdoptionRequest::where('user_id', Auth::id())
            ->where('pet_id', $pet->id)
            ->where('status', 'pending')
            ->first();
            
        if ($existingRequest) {
            return redirect()->back()->with('error', 'Ya tienes una solicitud pendiente para esta mascota.');
        }
        
        // Create adoption request
        AdoptionRequest::create([
            'user_id' => Auth::id(),
            'pet_id' => $pet->id,
            'message' => $validated['message'],
            'status' => 'pending',
            'admin_notes' => null,
        ]);
        
        // Update user information if needed
        $user = User::find(Auth::id());
        $user->dni = $validated['dni'];
        $user->phone = $validated['phone'];
        $user->save();
        
        // Update pet status to pending
        $pet->status = 'pending';
        $pet->save();
        
        return redirect()->route('user.pets.index')->with('success', 'Tu solicitud de adopción ha sido enviada y será evaluada por un administrador.');
    }
}
