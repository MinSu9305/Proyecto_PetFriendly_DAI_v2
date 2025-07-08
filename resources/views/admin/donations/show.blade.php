@extends('layouts.admin')

@section('content')
<div class="p-8 max-w-6xl mx-auto">
    <!-- Header mejorado -->
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('admin.donations.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-700 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            <span>Volver</span>
        </a>
    </div>

    <!-- Tarjeta principal -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Encabezado de la tarjeta -->
        <div class="bg-pet-yellow px-6 py-4 border-b border-amber-200">
            <h2 class="text-xl font-semibold text-gray-900">Detalle de Donación</h2>
        </div>

        <!-- Contenido en 2 columnas -->
        <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Columna izquierda - Información básica -->
            <div class="space-y-6">
                <!-- Sección de información personal -->
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Donante</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nombre</label>
                            <p class="text-gray-900 font-medium p-2 bg-white rounded">{{ explode(' ', $donation->donor_name)[0] ?? $donation->donor_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Apellido</label>
                            <p class="text-gray-900 font-medium p-2 bg-white rounded">{{ explode(' ', $donation->donor_name)[1] ?? '' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Sección de transacción -->
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Detalles de Transacción</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Fecha</label>
                            <p class="text-gray-900 p-2 bg-white rounded">{{ $donation->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Hora</label>
                            <p class="text-gray-900 p-2 bg-white rounded">{{ $donation->created_at->format('H:i') }}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Monto</label>
                            <p class="text-green-600 font-semibold text-xl p-2 bg-white rounded">S/. {{ number_format($donation->amount, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna derecha - Comprobante y comentarios -->
            <div class="space-y-6">
                <!-- Sección de comprobante -->
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Comprobante de Pago</h3>
                    @if($donation->receipt_path && Storage::disk('public')->exists($donation->receipt_path))
                        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                            <div class="flex-1 p-3 bg-white rounded-lg border border-gray-300 truncate">
                                <p class="text-gray-900 text-sm truncate">{{ basename($donation->receipt_path) }}</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.donations.receipt', $donation) }}"
                                   class="p-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center gap-2"
                                   title="Descargar comprobante">
                                    <i class="fas fa-download"></i>
                                    <span class="hidden sm:inline">Descargar</span>
                                </a>
                                @if(in_array(pathinfo($donation->receipt_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                <button onclick="viewReceipt('{{ Storage::url($donation->receipt_path) }}')"
                                        class="p-3 bg-lime-600 hover:bg-lime-700 text-white rounded-lg transition-colors flex items-center gap-2"
                                        title="Ver comprobante">
                                    <i class="fas fa-eye"></i>
                                    <span class="hidden sm:inline">Ver</span>
                                </button>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="p-3 bg-red-50 rounded-lg border border-red-200 text-center">
                            <p class="text-red-600">Sin comprobante adjunto</p>
                        </div>
                    @endif
                </div>

                <!-- Sección de comentarios -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">  
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Mensaje del Donante</h3>  
                    <div class="bg-white p-3 rounded-lg border border-gray-300 min-h-[100px]">  
                        <p class="text-gray-800 whitespace-pre-line">{{ $donation->message ?: 'El donante no dejó ningún mensaje.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para visualizar comprobante -->
<div id="receiptModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg max-w-4xl w-full mx-4 overflow-hidden">
        <div class="bg-pet-yellow px-4 py-3 flex justify-between items-center">
            <h3 class="font-bold">Comprobante de Donación</h3>
            <button onclick="closeReceiptModal()" class="text-gray-700 hover:text-gray-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-4 flex justify-center">
            <img id="receiptImage" src="" alt="Comprobante de donación" class="max-h-[80vh] max-w-full">
        </div>
    </div>
</div>

<script>
function viewReceipt(imageUrl) {
    document.getElementById('receiptImage').src = imageUrl;
    document.getElementById('receiptModal').classList.remove('hidden');
}

function closeReceiptModal() {
    document.getElementById('receiptModal').classList.add('hidden');
}
</script>
@endsection