@extends('layouts.user')

@section('content')
<div class="p-8 max-w-6xl mx-auto">
    <!-- Encabezado mejorado -->
    <div class="mb-6">
        <a href="{{ route('user.pets.index') }}" 
            class="inline-flex items-center px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-700 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver
        </a>
    </div>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Conoce a <span>{{ $pet->name }}</span></h1>
    </div>

    <!-- Contenido principal -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
            <!-- Foto de la mascota mejorada -->
            <div class="relative">
                @if($pet->images && count($pet->images) > 0)
                    <img src="{{ Storage::url($pet->images[0]) }}" 
                         alt="{{ $pet->name }}" 
                         class="w-full h-full min-h-[400px] object-cover ">
                @else
                    <div class="w-full h-full min-h-[400px] bg-gray-100 flex items-center justify-center">
                        <div class="text-center text-gray-400">
                            <i class="fas fa-paw text-8xl mb-4"></i>
                            <p class="text-xl">Imagen no disponible</p>
                        </div>
                    </div>
                @endif
                
                <!-- Badge de estado 
                <div class="absolute top-4 right-4 bg-white bg-opacity-90 px-3 py-1 rounded-full shadow-md">
                    <span class="font-medium text-sm {{ $pet->status === 'available' ? 'text-green-600' : ($pet->status === 'pending' ? 'text-yellow-600' : 'text-blue-600') }}">
                        {{ $pet->status_in_spanish }}
                    </span>
                </div>-->
            </div>
            
            <!-- Información de la mascota mejorada -->
            <div class="p-8 space-y-6">
                <!-- Datos principales -->
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">EDAD</p>
                        <p class="text-xl font-semibold text-gray-900">{{ $pet->age }} <span class="text-lg">años</span></p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">RAZA</p>
                        <p class="text-xl font-semibold text-gray-900">{{ $pet->raza ? $pet->raza->nombre : 'Sin raza especificada' }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">SEXO</p>
                        <p class="text-xl font-semibold text-gray-900">
                            {{ $pet->gender_in_spanish }}
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">TAMAÑO</p>
                        <p class="text-xl font-semibold text-gray-900">{{ $pet->size_in_spanish }}</p>
                    </div>
                </div>
                
                <!-- Descripción mejorada -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Sobre {{ $pet->name }}</h3>
                    <div class="prose max-w-none text-gray-700">
                        @if($pet->description)
                            {{ $pet->description }}
                        @else
                            <p class="text-gray-500 italic">No hay descripción disponible</p>
                        @endif
                    </div>
                </div>
                
                <!-- Botón de adopción mejorado -->
                <div class="pt-6">
                    <a href="{{ route('user.pets.adoption-form', $pet) }}" 
                       class="block w-full py-4 bg-yellow-400 hover:bg-yellow-500 text-black font-bold rounded-lg shadow-md text-center transition-colors duration-300 ">
                        <i class="fas fa-heart mr-2"></i> SOLICITAR ADOPCIÓN
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection