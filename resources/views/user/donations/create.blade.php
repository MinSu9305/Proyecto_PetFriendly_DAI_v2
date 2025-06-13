@extends('layouts.user')

@section('content')
<div class="p-8">
    <div class="flex items-center mb-8">
        <a href="{{ route('user.donations.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="text-4xl font-bold">Realizar Donación</h1>
    </div>
    
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8">
        <form id="donation-form" action="{{ route('user.donations.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Monto a donar (S/.)</label>
                <input type="number" id="amount" name="amount" min="1" step="0.01" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Mensaje (opcional)</label>
                <textarea id="message" name="message" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none"></textarea>
                @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div class="pt-4">
                <button type="button" onclick="confirmDonation()" class="w-full py-3 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                    Donar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function confirmDonation() {
        // Validar el formulario
        const form = document.getElementById('donation-form');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        const amount = document.getElementById('amount').value;
        
        // Mostrar modal de confirmación
        const actions = `
            <button onclick="document.getElementById('donation-form').submit()" class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                Confirmar
            </button>
            <button onclick="closeModal()" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg">
                Cancelar
            </button>
        `;
        
        showModal('Confirmar Donación', `¿Confirmar donación de S/. ${amount}?`, actions);
    }
</script>
@endsection
