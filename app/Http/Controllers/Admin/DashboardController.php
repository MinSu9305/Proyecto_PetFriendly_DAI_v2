<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pet;
use App\Models\AdoptionRequest;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Este es el controlador central del panel de administración
class DashboardController extends Controller
{
    public function index()
    {
        // Solo permitir acceso a usuarios admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder al dashboard.');
        }
        //Muestra el panel principal del admin
        return view('admin.dashboard');
    }


    public function adoptantes(Request $request)
    {
        $search = $request->get('search');
        // Lista los usuarios con rol "user" 
        $adoptantes = User::where('role', 'user')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        // Devuelve la vista admin.adoptantes
        return view('admin.adoptantes', compact('adoptantes', 'search'));
    }

    public function mascotas()
    {
        // Lista las mascotas con adopciones aprobadas
        $mascotas = Pet::with('approvedAdoption.user')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.mascotas', compact('mascotas'));
    }
//Obtiene todas las solicitudes de adopción
    public function solicitudes()
    {
        $solicitudes = AdoptionRequest::with(['user', 'pet'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.adoption-requests', compact('solicitudes'));
    }
//Muestra las donaciones
    public function donaciones()
    {
        $donations = Donation::with('user')->orderBy('created_at', 'desc')->paginate(5);

        return view('admin.donations.index', compact('donations'));
    }
//datos de un adoptante en detalle
    // Método mejorado (opcional)
public function viewAdoptante(User $user)
{
    $adoptionRequests = $user->adoptionRequests()->with('pet')->get();
    $donations = $user->donations()->get();
    
    return response()->json([
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'birth_date' => $user->birth_date,
            'profile_photo_path' => $user->profile_photo_path, 
            'role' => $user->role,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ],
        'adoptionRequests' => $adoptionRequests,
        'donations' => $donations,
    ]);
}
    public function deleteAdoptante(User $user)
    {
        //Elimina un adoptante del sistema, con validación para no eliminar admins
        if ($user->role === 'admin') {
            return response()->json(['error' => 'No se puede eliminar un administrador'], 403);
        }

        $user->delete();

        return response()->json(['success' => 'Adoptante eliminado correctamente']);
    }
}
