@extends('layouts.admin')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="flex items-center mb-8">
        <a href="{{ route('admin.pets.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Detalles de {{ $pet->name }}</h1>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Información -->
            <div class="space-y-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Información Básica</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nombre</p>
                            <p class="font-medium">{{ $pet->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Edad</p>
                            <p class="font-medium">{{ $pet->age }} {{ $pet->age == 1 ? 'año' : 'años' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Especie</p>
                            <p class="font-medium">{{ $pet->type_in_spanish }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Raza</p>
                            <p class="font-medium">{{ $pet->breed }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Sexo</p>
                            <p class="font-medium">{{ $pet->gender_in_spanish }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tamaño</p>
                            <p class="font-medium">{{ $pet->size_in_spanish }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Estado</p>
                            <p>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $pet->status === 'available' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $pet->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $pet->status === 'adopted' ? 'bg-blue-100 text-blue-800' : '' }}">
                                    {{ $pet->status_in_spanish }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Estado de Salud</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Vacunado</p>
                            <p class="font-medium">{{ $pet->is_vaccinated ? 'Sí' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Esterilizado</p>
                            <p class="font-medium">{{ $pet->is_sterilized ? 'Sí' : 'No' }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Descripción</h2>
                    <p class="text-gray-700">{{ $pet->description }}</p>
                </div>

                <div class="pt-4">
                    <a href="{{ route('admin.pets.edit', $pet) }}" 
                       class="inline-flex items-center px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                        <i class="fas fa-edit mr-2"></i> Editar Mascota
                    </a>
                </div>
            </div>

            <!-- Foto -->
            <div>
                @if($pet->images && count($pet->images) > 0)
                    <img src="{{ Storage::url($pet->images[0]) }}" 
                         alt="{{ $pet->name }}" 
                         class="w-full h-96 object-cover rounded-lg shadow-md">
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center shadow-md">
                        <div class="text-center text-gray-500">
                            <i class="fas fa-paw text-6xl mb-4"></i>
                            <p class="text-xl">Sin foto</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
