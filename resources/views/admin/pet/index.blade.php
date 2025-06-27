@extends('layouts.admin')

@section('content')
<div class="p-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Listar Mascotas</h1>
    </div>
        <!-- Header con buscador y botón -->
    <div class="mb-6 flex justify-between items-center">
        <form method="GET" action="{{ route('admin.pets.index') }}" class="flex gap-4">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                placeholder="Buscar por nombre, raza, especie"
                class="w-96 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            
            <button type="submit"
                class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                <i class="fas fa-search"></i> Buscar
            </button>

            @if (!empty($search))
                <a href="{{ route('admin.pets.index') }}"
                    class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg">
                    Limpiar
                </a>
            @endif
        </form>

        <a href="{{ route('admin.pets.create') }}"
            class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Agregar nueva mascota</span>
        </a>
    </div>


    <!-- Mensaje -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Tabla -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-pet-yellow">
                <tr>
                    <th class="px-6 py-4 text-left text-black font-bold">Nombre</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Edad</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Especie</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Raza</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Sexo</th>
                    <th class="px-6 py-4 text-center text-black font-bold">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($pets as $pet)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $pet->name }}</td>
                    <td class="px-6 py-4 text-gray-900">{{ $pet->age }} {{ $pet->age == 1 ? 'año' : 'años' }}</td>
                    <td class="px-6 py-4 text-gray-900">{{ $pet->type_in_spanish }}</td>
                    <td class="px-6 py-4 text-gray-900">{{ $pet->raza ? $pet->raza->nombre : 'Sin raza' }}</td>
                    <td class="px-6 py-4 text-gray-900">{{ $pet->gender_in_spanish }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('admin.pets.show', $pet) }}" 
                               class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.pets.edit', $pet) }}" 
                               class="p-2 text-green-600 hover:bg-green-100 rounded-lg" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        No se encontraron mascotas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginacion -->
    @if($pets->hasPages())
    <div class="mt-6">
        {{ $pets->links() }}
    </div>
    @endif
</div>
@endsection
