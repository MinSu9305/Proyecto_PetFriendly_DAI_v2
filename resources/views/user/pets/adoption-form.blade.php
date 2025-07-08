@extends('layouts.user')

@section('content')
<div class="p-8 max-w-6xl mx-auto">
    <!-- Encabezado mejorado -->
      <div class="mb-4">
        <a href="{{ route('user.pets.show', $pet) }}" 
            class="inline-flex items-center px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-700 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver
        </a>
    </div>

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Formulario de Adopción</h1>
    </div>
    
    <!-- Contenedor principal -->
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sección de la mascota -->
        <div class="w-full lg:w-1/3">
            <div class="bg-white rounded-xl shadow-md overflow-hidden sticky top-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Estás adoptando a</h2>
                    <p class="text-2xl font-bold text-yellow-600">{{ $pet->name }}</p>
                </div>
                
                <div class="p-6">
                    @if($pet->images && count($pet->images) > 0)
                        <img src="{{ Storage::url($pet->images[0]) }}" 
                             alt="{{ $pet->name }}" 
                             class="w-full h-64 object-cover rounded-lg mb-4">
                    @else
                        <div class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-paw text-6xl text-gray-400"></i>
                        </div>
                    @endif
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Edad</span>
                            <span class="font-medium">{{ $pet->age }} años</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Raza</span>
                            <span class="font-medium">{{ $pet->raza ? $pet->raza->nombre : 'Sin raza' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sexo</span>
                            <span class="font-medium">{{ $pet->gender_in_spanish }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Formulario de adopción -->
        <div class="w-full lg:w-2/3">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-8">
                    <form id="adoption-form" action="{{ route('user.pets.submit-adoption', $pet) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Datos del Adoptante</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombres</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" value="{{ explode(' ', $user->name)[0] ?? $user->name }}" readonly
                                           class="pl-10 w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Apellidos</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" value="{{ explode(' ', $user->name)[1] ?? '' }}" readonly
                                           class="pl-10 w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                            
                            <div>
                                <label for="dni" class="block text-sm font-medium text-gray-700 mb-2">D.N.I</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                    </div>
                                    <input type="text" id="dni" name="dni" value="{{ $user->dni ?? '' }}" required
                                           pattern="[0-9]*" inputmode="numeric"
                                           class="pl-10 w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 focus:outline-none"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                                @error('dni') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Celular</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-mobile-alt text-gray-400"></i>
                                    </div>
                                    <input type="text" id="phone" name="phone" value="{{ $user->phone ?? '' }}" required
                                           pattern="[0-9]*" inputmode="numeric"
                                           class="pl-10 w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 focus:outline-none"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                                @error('phone') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Motivo de Adopción</label>
                            <textarea id="message" name="message" rows="3" required placeholder="Cuéntanos por qué quieres adoptar a {{ $pet->name }}..."
                                      class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 focus:outline-none"></textarea>
                            @error('message') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="pt-4">
                            <button type="button" onclick="confirmAdoption()" 
                                    class="w-full py-4 bg-yellow-400 hover:bg-yellow-500 text-black font-bold rounded-lg shadow-md transition-colors duration-300">
                                <i class="fas fa-paper-plane mr-2"></i> Enviar Solicitud
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

    // Función para cerrar modal (asegúrate de tenerla definida)
    function closeModal() {
        // Implementación de cierre de modal
    }
</script>
@endsection