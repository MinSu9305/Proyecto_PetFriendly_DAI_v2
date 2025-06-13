@extends('layouts.user')

@section('content')
<div class="p-8">
    <div class="flex items-center mb-8">
        <a href="{{ route('user.pets.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="text-4xl font-bold">Conoce a {{ $pet->name }}</h1>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Foto de la mascota -->
        <div class="bg-pet-yellow rounded-lg overflow-hidden">
            @if($pet->images && count($pet->images) > 0)
                <img src="{{ Storage::url($pet->images[0]) }}" alt="{{ $pet->name }}" class="w-full h-96 object-cover">
            @else
                <div class="w-full h-96 flex items-center justify-center">
                    <i class="fas fa-paw text-6xl text-gray-700"></i>
                </div>
            @endif
        </div>
        
        <!-- Información de la mascota -->
        <div class="space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">EDAD (Años):</p>
                    <p class="font-semibold">{{ $pet->age }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">RAZA:</p>
                    <p class="font-semibold">{{ $pet->breed }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">SEXO:</p>
                    <p class="font-semibold">{{ $pet->gender_in_spanish }}</p>
                </div>
            </div>
            
            <div>
                <p class="text-sm font-medium text-gray-500">DESCRIPCIÓN:</p>
                <p class="mt-2">{{ $pet->description }}</p>
            </div>
            
            <div class="pt-4">
                <a href="{{ route('user.pets.adoption-form', $pet) }}" class="block w-full py-3 bg-black text-white text-center font-semibold rounded-lg hover:bg-gray-800">
                    SOLICITAR ADOPCIÓN
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
