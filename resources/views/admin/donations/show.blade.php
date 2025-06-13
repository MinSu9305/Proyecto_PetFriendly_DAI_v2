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

    <!-- Content -->
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
                <input type="text" value="{{ number_format($donation->amount, 2) }}" readonly
                       class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Comprobante</label>
                <div class="flex items-center">
                    <span class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg flex-grow">
                        donacion-{{ $donation->id }}.pdf
                    </span>
                    <a href="{{ route('admin.donations.certificate', $donation) }}" 
                       class="ml-2 px-3 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Comentarios -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Comentarios</label>
            <textarea readonly rows="4" 
                      class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">{{ $donation->message }}</textarea>
        </div>
    </div>
</div>
@endsection
