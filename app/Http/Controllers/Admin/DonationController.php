<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $donations = Donation::when($search, function ($query, $search) {
                return $query->where('donor_name', 'like', "%{$search}%")
                           ->orWhere('donor_email', 'like', "%{$search}%")
                           ->orWhere('amount', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.donations.index', compact('donations', 'search'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        return view('admin.donations.show', compact('donation'));
    }

    /**
     * Generate a PDF certificate for the donation.
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
