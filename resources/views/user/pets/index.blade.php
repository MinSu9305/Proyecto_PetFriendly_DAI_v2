@extends('layouts.user')

@section('content')
<div class="p-8">
    <div class="flex items-center mb-4">
        <h1 class="text-4xl font-bold">ADOPTA A TU PetFriendly</h1>
    </div>
    
    <!-- Filtros -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-2">FILTRAR POR</h2>
        <form action="{{ route('user.pets.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-base font-medium text-gray-700 mb-1">Especie</label>
                <select name="especie_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    <option value="">Todas las especies</option>
                    @foreach($especies as $especie)
                        <option value="{{ $especie->id }}" {{ $especieId == $especie->id ? 'selected' : '' }}>
                            {{ $especie->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-base font-medium text-gray-700 mb-1">Sexo</label>
                <select name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    <option value="">Todos</option>
                    <option value="female" {{ $gender === 'female' ? 'selected' : '' }}>Hembra</option>
                    <option value="male" {{ $gender === 'male' ? 'selected' : '' }}>Macho</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                    Filtrar
                </button>
                <!-- Botón para limpiar filtros -->
                <a href="{{ route('user.pets.index') }}" class="ml-2 px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg">
                    Limpiar
                </a>
            </div>
        </form>
    </div>
    
    <!-- Mostrar filtros activos 
    @if($especieId || $gender)
        <div class="mb-4 p-3 bg-blue-50 rounded-lg">
            <p class="text-sm text-blue-800">
                <strong>Filtros activos:</strong>
                @if($especieId)
                    Especie: {{ $especies->find($especieId)->nombre ?? 'Desconocida' }}
                @endif
                @if($especieId && $gender) | @endif
                @if($gender)
                    Sexo: {{ $gender === 'female' ? 'Hembra' : 'Macho' }}
                @endif
            </p>
        </div>
    @endif
    -->
    <!-- Mascotas -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($pets as $pet)
            <div class="flex flex-col items-center">
                <div class="w-full h-48 mb-2 overflow-hidden rounded-lg">
                    @if($pet->images && count($pet->images) > 0)
                        <img src="{{ Storage::url($pet->images[0]) }}" alt="{{ $pet->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-paw text-4xl text-gray-400"></i>
                        </div>
                    @endif
                </div>
                <h3 class="font-semibold text-lg">{{ $pet->name }}</h3>
                <!-- Mostrar especie y raza 
                <p class="text-sm text-gray-600 mb-1">
                    {{ $pet->especie->nombre ?? 'Sin especie' }}
                    @if($pet->raza)
                        - {{ $pet->raza->nombre }}
                    @endif
                </p>
                <p class="text-sm text-gray-500 mb-2">
                    {{ $pet->gender === 'female' ? 'Hembra' : 'Macho' }}
                </p>-->
                <a href="{{ route('user.pets.show', $pet) }}" class="mt-2 px-4 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-full text-sm">
                    CONÓCEME
                </a>
            </div>
        @empty
            <div class="col-span-4 text-center py-8">
                <p class="text-gray-500">No hay mascotas disponibles con los filtros seleccionados.</p>
                @if($especieId || $gender)
                    <a href="{{ route('user.pets.index') }}" class="mt-2 inline-block px-4 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                        Ver todas las mascotas
                    </a>
                @endif
            </div>
        @endforelse
    </div>
    
    <!-- Paginación -->
    <div class="mt-8 flex justify-center">
        {{ $pets->appends(request()->query())->links() }}
    </div>
</div>
@endsection