@extends('layouts.user')

@section('content')
<div class="p-8">
    <div class="flex items-center mb-8">
        <a href="{{ route('user.pets.show', $pet) }}" class="mr-4 text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="text-4xl font-bold">Formulario de<br>SOLICITUD DE ADOPCIÓN</h1>
    </div>
    
    <div class="max-w-2xl mx-auto bg-gray-50 rounded-lg p-8">
        <form id="adoption-form" action="{{ route('user.pets.submit-adoption', $pet) }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mascota</label>
                <input type="text" value="{{ $pet->name }}" readonly
                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg">
            </div>
            
            <div class="mt-6">
                <p class="font-medium mb-2">Datos del Adoptante:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombres</label>
                        <input type="text" value="{{ explode(' ', $user->name)[0] ?? $user->name }}" readonly
                               class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                        <input type="text" value="{{ explode(' ', $user->name)[1] ?? '' }}" readonly
                               class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">D.N.I</label>
                        <input type="text" id="dni" name="dni" value="{{ $user->dni ?? '' }}" required
                               class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        @error('dni') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Celular</label>
                        <input type="text" id="phone" name="phone" value="{{ $user->phone ?? '' }}" required
                               class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Motivo de Adopción</label>
                <textarea id="message" name="message" rows="6" required placeholder="Escribir..."
                          class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none"></textarea>
                @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex justify-center pt-4">
                <button type="button" onclick="confirmAdoption()" class="px-8 py-3 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                    Enviar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function confirmAdoption() {
        // Validar el formulario
        const form = document.getElementById('adoption-form');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Mostrar modal de confirmación
        const actions = `
            <button onclick="document.getElementById('adoption-form').submit()" class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                Aceptar
            </button>
            <button onclick="closeModal()" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg">
                Cancelar
            </button>
        `;
        
        showModal('Confirmar Solicitud', '¿Confirmar solicitud de adopción?', actions);
    }
</script>
@endsection
