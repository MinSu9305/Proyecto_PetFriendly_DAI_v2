@extends('layouts.admin')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="flex items-center mb-8">
        <a href="{{ route('admin.donations.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Donación de</h1>
    </div>

    <!-- Contenido -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-3 gap-4 mb-6">
    <!-- Información del donante -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
        <input type="text" value="{{ explode(' ', $donation->donor_name)[0] ?? $donation->donor_name }}" readonly
               class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
        <input type="text" value="{{ explode(' ', $donation->donor_name)[1] ?? '' }}" readonly
               class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
        <input type="text" value="{{ $donation->created_at->format('d/m/Y') }}" readonly
               class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Hora</label>
        <input type="text" value="{{ $donation->created_at->format('H:i') }}" readonly
               class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Monto</label>
        <input type="text" value="S/. {{ number_format($donation->amount, 2) }}" readonly
               class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
    </div>
    
    <!-- COMPROBANTE DEL USUARIO - ACTUALIZADO -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Comprobante del Usuario</label>
        <div class="flex items-center gap-2">
            @if($donation->receipt_path && Storage::disk('public')->exists($donation->receipt_path))
                <span class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg flex-grow text-sm">
                    {{ basename($donation->receipt_path) }}
                </span>
                <a href="{{ route('admin.donations.receipt', $donation) }}"
                   class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg"
                   title="Descargar comprobante del usuario">
                    <i class="fas fa-download"></i>
                </a>
                <!-- Botón para ver en nueva ventana si es imagen -->
                @if(in_array(pathinfo($donation->receipt_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                <button onclick="viewReceipt('{{ Storage::url($donation->receipt_path) }}')"
                        class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg"
                        title="Ver comprobante">
                    <i class="fas fa-eye"></i>
                </button>
                @endif
            @else
                <span class="px-3 py-2 bg-red-100 border border-red-300 rounded-lg flex-grow text-sm text-red-600">
                    Sin comprobante
                </span>
            @endif
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

        <!-- Paginacion -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Comentarios</label>
            <textarea readonly rows="4" 
                      class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">{{ $donation->message }}</textarea>
        </div>
    </div>
</div>
@endsection
