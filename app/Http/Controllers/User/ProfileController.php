<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User as EloquentUser;
use App\Models\AdoptionRequest;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class ProfileController extends Controller
{
    /**
     * Muestra el perfil del usuario
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user instanceof \App\Models\User) {
            $user = EloquentUser::find($user->id);
        }
        $adoptionRequests = AdoptionRequest::where('user_id', $user->id)
            ->with('pet')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $donations = Donation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('user.profile.index', compact('user', 'adoptionRequests', 'donations'));
    }

    /**
     * Actualiza información básica del perfil
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user instanceof \App\Models\User) {
            $user = EloquentUser::find($user->id);
        }
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        //$user->birth_date = $validated['birth_date'];
        $user->save();
        
        return redirect()->route('user.profile')->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Actualiza la foto de perfil:
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:2048'], // 2MB max
        ]);
        
        $user = Auth::user();
        if (!$user instanceof \App\Models\User) {
            $user = EloquentUser::find($user->id);
        }
        
        // Borra imagen anterior si existe


        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        
        // Guarda nueva imagen
        $photoPath = $request->file('photo')->store('profile-photos', 'public');
        $user->profile_photo_path = $photoPath;
        $user->save();
        
        return redirect()->route('user.profile')->with('success', 'Foto de perfil actualizada correctamente');
    }
}
