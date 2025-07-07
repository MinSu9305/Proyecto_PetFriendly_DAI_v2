@extends('layouts.admin')

@section('content')
<div class="p-8 max-w-7xl mx-auto">
   <!-- Header consistente con create/edit -->
<div class="mb-6">
    <!-- Botón volver -->
    <div class="mb-5">
        <a href="{{ route('admin.pets.index') }}" 
            class="inline-flex items-center px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-700 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver
        </a>
    </div>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detalles de {{ $pet->name }}</h1>
        </div>
    </div>
</div>

    <!-- Contenido principal -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="flex flex-col lg:flex-row">
            <!-- Sección de imagen -->
            <div class="w-full lg:w-2/5 p-6 bg-white border-r border-gray-200">
                @if($pet->images && count($pet->images) > 0)
                    <div class="relative pb-[100%] rounded-lg overflow-hidden shadow-lg">
                        <img src="{{ Storage::url($pet->images[0]) }}" 
                             alt="{{ $pet->name }}" 
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                    </div>
                @else
                    <div class="relative pb-[100%] bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center shadow-inner">
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                            <i class="fas fa-paw text-6xl mb-4"></i>
                            <p class="text-xl font-medium">Sin foto disponible</p>
                        </div>
                    </div>
                @endif
                
            </div>
            
            <!-- Sección de información -->
            <div class="w-full lg:w-3/5 p-6">
                <!-- Tarjeta de información básica -->
                <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                        <i class="fas fa-info-circle text-yellow-500 mr-2"></i>
                        Información Básica
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Fila 1 -->
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">Nombre</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pet->name }}</p>
                        </div>
                        
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">Edad</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $pet->age }} {{ $pet->age == 1 ? 'año' : 'años' }}
                            </p>
                        </div>
                        
                        <!-- Fila 2 -->
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">Especie</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $pet->raza && $pet->raza->especie ? $pet->raza->especie->nombre : 'No especificado' }}
                            </p>
                        </div>
                        
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">Raza</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $pet->raza ? $pet->raza->nombre : 'No especificado' }}
                            </p>
                        </div>
                        
                        <!-- Fila 3 -->
                        <div class="space-y-1">
    <p class="text-sm font-medium text-gray-500">Sexo</p>
    <p class="text-lg font-semibold text-gray-900">
        {{ $pet->gender_in_spanish }}
    </p>
</div>
                        
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">Tamaño</p>
                            <p class="text-lg font-semibold text-gray-900">
                                
                                {{ $pet->size_in_spanish }}
                            </p>
                        </div>
                        
                        <!-- Fila 4 -->
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">Estado</p>
                            <p class="text-lg font-semibold">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm
                                    {{ $pet->status === 'available' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $pet->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $pet->status === 'adopted' ? 'bg-blue-100 text-blue-800' : '' }}">
                                    @if($pet->status === 'available')
                                        <i class="fas fa-check-circle mr-2"></i>
                                    @elseif($pet->status === 'pending')
                                        <i class="fas fa-clock mr-2"></i>
                                    @else
                                        <i class="fas fa-heart mr-2"></i>
                                    @endif
                                    {{ $pet->status_in_spanish }}
                                </span>
                            </p>
                        </div>
                        
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">Registrado el</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $pet->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Tarjeta de descripción -->
                <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                        <i class="fas fa-align-left text-yellow-500 mr-2"></i>
                        Descripción
                    </h2>
                    
                    <div class="prose max-w-none text-gray-700">
                        @if($pet->description)
                            {{ $pet->description }}
                        @else
                            <p class="text-gray-400 italic">No hay descripción disponible</p>
                        @endif
                    </div>
                </div>
                
                <!-- Tarjeta de salud (opcional) -->
                <!--
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                        <i class="fas fa-heartbeat text-red-500 mr-2"></i>
                        Estado de Salud
                    </h2>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">Vacunado</p>
                            <p class="text-lg font-semibold {{ $pet->is_vaccinated ? 'text-green-600' : 'text-gray-600' }}">
                                {{ $pet->is_vaccinated ? 'Sí' : 'No' }}
                            </p>
                        </div>
                        
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">Esterilizado</p>
                            <p class="text-lg font-semibold {{ $pet->is_sterilized ? 'text-green-600' : 'text-gray-600' }}">
                                {{ $pet->is_sterilized ? 'Sí' : 'No' }}
                            </p>
                        </div>
                    </div>
                </div>
                -->
            </div>
        </div>
    </div>
</div>
@endsection