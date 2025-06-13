<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdoptionRequest;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdoptionRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $adoptionRequests = AdoptionRequest::with(['user', 'pet'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('pet', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.adoption-requests.index', compact('adoptionRequests', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'pet_id' => 'required|exists:pets,id',
            'message' => 'required|min:10',
        ], [
            'user_id.required' => 'El adoptante es requerido',
            'user_id.exists' => 'El adoptante seleccionado no existe',
            'pet_id.required' => 'La mascota es requerida',
            'pet_id.exists' => 'La mascota seleccionada no existe',
            'message.required' => 'El motivo de adopción es requerido',
            'message.min' => 'El motivo debe tener al menos 10 caracteres',
        ]);

        // Verificar que la mascota esté disponible
        $pet = Pet::findOrFail($validated['pet_id']);
        if ($pet->status !== 'available') {
            return redirect()->back()->with('error', 'La mascota seleccionada no está disponible para adopción.');
        }

        AdoptionRequest::create([
            'user_id' => $validated['user_id'],
            'pet_id' => $validated['pet_id'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        return redirect()->route('admin.adoption-requests.index')
            ->with('success', 'Solicitud de adopción creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AdoptionRequest $adoptionRequest)
    {
        $adoptionRequest->load(['user', 'pet']);
        return view('admin.adoption-requests.show', compact('adoptionRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdoptionRequest $adoptionRequest)
    {
        $adoptionRequest->load(['user', 'pet']);
        $users = User::where('role', 'user')->get();
        $pets = Pet::whereIn('status', ['available', $adoptionRequest->pet->status])->get();
        
        return view('admin.adoption-requests.edit', compact('adoptionRequest', 'users', 'pets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdoptionRequest $adoptionRequest)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'pet_id' => 'required|exists:pets,id',
            'message' => 'required|min:10',
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string',
        ], [
            'user_id.required' => 'El adoptante es requerido',
            'user_id.exists' => 'El adoptante seleccionado no existe',
            'pet_id.required' => 'La mascota es requerida',
            'pet_id.exists' => 'La mascota seleccionada no existe',
            'message.required' => 'El motivo de adopción es requerido',
            'message.min' => 'El motivo debe tener al menos 10 caracteres',
            'status.required' => 'El estado es requerido',
            'status.in' => 'El estado debe ser pendiente, aprobado o rechazado',
        ]);

        $data = [
            'user_id' => $validated['user_id'],
            'pet_id' => $validated['pet_id'],
            'message' => $validated['message'],
            'status' => $validated['status'],
            'admin_notes' => $request->admin_notes,
        ];

        // Si se aprueba la solicitud, actualizar la mascota y registrar quién aprobó
        if ($validated['status'] === 'approved' && $adoptionRequest->status !== 'approved') {
            $data['approved_at'] = now();
            $data['approved_by'] = Auth::id();
            
            // Actualizar estado de la mascota
            $pet = Pet::findOrFail($validated['pet_id']);
            $pet->update(['status' => 'adopted']);
        }

        $adoptionRequest->update($data);

        return redirect()->route('admin.adoption-requests.index')
            ->with('success', 'Solicitud de adopción actualizada exitosamente.');
    }

    /**
     * Process the adoption request (approve or reject).
     */
    public function process(Request $request, AdoptionRequest $adoptionRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $data = [
            'status' => $validated['status'],
            'admin_notes' => $request->admin_notes,
        ];

        // Si se aprueba la solicitud
        if ($validated['status'] === 'approved') {
            $data['approved_at'] = now();
            $data['approved_by'] = Auth::id();
            
            // Actualizar estado de la mascota
            $pet = $adoptionRequest->pet;
            $pet->update(['status' => 'adopted']);
        }

        $adoptionRequest->update($data);

        $message = $validated['status'] === 'approved' 
            ? 'Solicitud de adopción aprobada exitosamente.' 
            : 'Solicitud de adopción rechazada.';

        return redirect()->route('admin.adoption-requests.index')
            ->with('success', $message);
    }
}
