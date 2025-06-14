<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF; //Librería DomPDF usada para generar archivos PDF desde vistas Blade.

//Este controlador va a gestionar las donaciones realizadas y además generar certificados en PDF
class DonationController extends Controller
{
    /**
     * Muestra la lista de donaciones, con opción de búsqueda. / (Nombre del donante, Correo, Monto)
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $donations = Donation::when($search, function ($query, $search) {
                return $query->where('donor_name', 'like', "%{$search}%")
                           ->orWhere('amount', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.donations.index', compact('donations', 'search'));
    }

    /**
     * Muestra los detalles de una sola donación.
     */
    public function show(Donation $donation)
    {
        return view('admin.donations.show', compact('donation'));
    }

    /**
     *  Genera un certificado de donación en PDF con los datos de la donación.
     */
    public function generateCertificate(Donation $donation)
    {
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
        $pdf = PDF::loadView('admin.donations.certificate', $data);
        
        // Descargar el PDF
        return $pdf->download('certificado-donacion-' . $donation->id . '.pdf');
    }
}
