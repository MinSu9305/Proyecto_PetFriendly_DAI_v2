<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pet;
use App\Models\AdoptionRequest;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Solo permitir acceso a usuarios admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder al dashboard.');
        }

        return view('admin.dashboard');
    }


    public function adoptantes(Request $request)
    {
        $search = $request->get('search');

        $adoptantes = User::where('role', 'user')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.adoptantes', compact('adoptantes', 'search'));
    }

    public function mascotas()
    {
        $mascotas = Pet::with('approvedAdoption.user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.mascotas', compact('mascotas'));
    }

    public function solicitudes()
    {
        $solicitudes = AdoptionRequest::with(['user', 'pet'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.adoption-requests', compact('solicitudes'));
    }

    public function donaciones()
    {
        $donations = Donation::with('user')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.donations.index', compact('donations'));
    }

    public function viewAdoptante(User $user)
    {
        $adoptionRequests = $user->adoptionRequests()->with('pet')->get();
        $donations = $user->donations()->get();

        return response()->json([
            'user' => $user,
            'adoptionRequests' => $adoptionRequests,
            'donations' => $donations,
        ]);
    }

    public function deleteAdoptante(User $user)
    {
        if ($user->role === 'admin') {
            return response()->json(['error' => 'No se puede eliminar un administrador'], 403);
        }

        $user->delete();

        return response()->json(['success' => 'Adoptante eliminado correctamente']);
    }
}
