<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
// Este controlador permite a los usuarios autenticados ver, registrar y descargar certificados de sus donaciones
class DonationController extends Controller
{
    /**
     * Muestra un listado paginado de las donaciones hechas por el usuario
     */
    public function index()
    {
        $donations = Donation::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(5);
            
        return view('user.donations.index', compact('donations'));
    }

    /**
     * Muestra el formulario para hacer una nueva donación
     */
    public function create()
    {
        return view('user.donations.create');
    }

    /**
     * Guarda una nueva donación en la base de datos:
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string',
        ]);
        
        $user = Auth::user();
        
        $donation = Donation::create([
            'user_id' => $user->id,
            'donor_name' => $user->name,
            'donor_email' => $user->email,
            'amount' => $validated['amount'],
            'status' => 'completed', // Simulamos que el pago fue exitoso
            'transaction_id' => 'SIMULATED-' . uniqid(),
            'message' => $validated['message'] ?? null,
        ]);
        
        return redirect()->route('user.donations.index')->with('success', 'Donación realizada con éxito. ¡Gracias por tu aporte!');
    }

    /**
     * Genera un PDF descargable de certificado
     */
    public function downloadCertificate(Donation $donation)
    {
        // Verificar que la donación pertenece al usuario autenticado
        if ($donation->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Generar un número de certificado único
        $certificateNumber = 'PF-' . str_pad($donation->id, 8, '0', STR_PAD_LEFT);
        
        // Formatear la fecha en español
        $date = \Carbon\Carbon::parse($donation->created_at)->locale('es')->isoFormat('D [de] MMMM [de] YYYY');
        
        // Formatear el monto
        $amount = number_format($donation->amount, 2) . ' Nuevos Soles';
        
        // Datos para el PDF
        $data = [
            'donation' => $donation,
            'certificateNumber' => $certificateNumber,
            'formattedDate' => $date,
            'formattedAmount' => $amount,
        ];
        
        // Generar el PDF
        $pdf = Pdf::loadView('user.donations.certificate', $data);
        
        // Descargar el PDF
        return $pdf->download('certificado-donacion-' . $donation->id . '.pdf');
    }
}
