@extends('layouts.admin')

@section('content')
<div class="p-8 max-w-7xl mx-auto">
    <!-- Header -->
     <!-- Botón volver -->
    <div class="mb-4">
        <a href="{{ route('admin.adoption-requests.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-700 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver
        </a>
    </div>

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Editar Solicitud</h1>
    </div>

    <!-- Contenido principal en dos columnas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Columna izquierda - Información del adoptante y mascota -->
        <div class="space-y-6">
            <!-- Tarjeta de adoptante -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-pet-yellow px-6 py-4 border-b border-amber-200">
                    <h2 class="text-xl font-semibold text-gray-900">Datos del Adoptante</h2>
                </div>
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nombre completo</label>
                        <p class="text-gray-900 font-medium p-2 bg-gray-50 rounded-lg">{{ $adoptionRequest->user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Correo electrónico</label>
                        <p class="text-gray-900 p-2 bg-gray-50 rounded-lg">{{ $adoptionRequest->user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Teléfono</label>
                        <p class="text-gray-900 p-2 bg-gray-50 rounded-lg">123456789</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">DNI</label>
                        <p class="text-gray-900 p-2 bg-gray-50 rounded-lg">87654321</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de mascota -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-pet-yellow px-6 py-4 border-b border-amber-200">
                    <h2 class="text-xl font-semibold text-gray-900">Mascota a Adoptar</h2>
                </div>
                
                <div class="p-6 flex items-start space-x-4">
                    @if($adoptionRequest->pet->images && count($adoptionRequest->pet->images) > 0)
                    <img src="{{ Storage::url($adoptionRequest->pet->images[0]) }}" 
                         alt="{{ $adoptionRequest->pet->name }}"
                         class="w-24 h-24 object-cover rounded-lg">
                    @endif
                    
                    <div class="grid grid-cols-2 gap-4 flex-1">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nombre</label>
                            <p class="text-gray-900 font-medium p-2 bg-gray-50 rounded-lg">{{ $adoptionRequest->pet->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Especie</label>
                            <p class="text-gray-900 p-2 bg-gray-50 rounded-lg">{{ $adoptionRequest->pet->raza->especie->nombre ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Raza</label>
                            <p class="text-gray-900 p-2 bg-gray-50 rounded-lg">{{ $adoptionRequest->pet->raza ? $adoptionRequest->pet->raza->nombre : 'Sin raza' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Edad</label>
                            <p class="text-gray-900 p-2 bg-gray-50 rounded-lg">{{ $adoptionRequest->pet->age }} años</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Sexo</label>
                            <p class="text-gray-900 p-2 bg-gray-50 rounded-lg">{{ $adoptionRequest->pet->gender_in_spanish }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna derecha - Formulario de gestión -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-pet-yellow px-6 py-4 border-b border-amber-200">
                <h2 class="text-xl font-semibold text-gray-900">Gestión de la Solicitud</h2>
            </div>
            
            <form action="{{ route('admin.adoption-requests.update', $adoptionRequest) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Campos ocultos necesarios -->
                <input type="hidden" name="user_id" value="{{ $adoptionRequest->user_id }}">
                <input type="hidden" name="pet_id" value="{{ $adoptionRequest->pet_id }}">
                <input type="hidden" name="message" value="{{ $adoptionRequest->message }}">
                
                <!-- Estado -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Estado actual</label>
                    <select name="status" id="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition-colors">
                        <option value="pending" {{ old('status', $adoptionRequest->status) == 'pending' ? 'selected' : '' }}>
                            Pendiente
                        </option>
                        <option value="approved" {{ old('status', $adoptionRequest->status) == 'approved' ? 'selected' : '' }}>
                            Aprobada
                        </option>
                        <option value="rejected" {{ old('status', $adoptionRequest->status) == 'rejected' ? 'selected' : '' }}>
                            Rechazada
                        </option>
                    </select>
                </div>
                
                <!-- Motivo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motivo de adopción</label>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 h-40 overflow-y-auto">
                        <p class="text-gray-800 text-sm whitespace-pre-line">{{ $adoptionRequest->message }}</p>
                    </div>
                </div>
                
                <!-- Notas del admin -->
                <div>
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Notas internas</label>
                    <textarea name="admin_notes" id="admin_notes" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition-colors"
                        placeholder="Agregar observaciones...">{{ old('admin_notes', $adoptionRequest->admin_notes) }}</textarea>
                </div>
                
                <!-- Botones -->
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
                    <a href="{{ route('admin.adoption-requests.index') }}"
                        class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition-colors flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection