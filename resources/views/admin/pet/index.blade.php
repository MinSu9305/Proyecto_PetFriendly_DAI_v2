@extends('layouts.admin')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Listar Mascotas</h1>
        <a href="{{ route('admin.pets.create') }}" class="bg-pet-yellow hover:bg-pet-yellow-dark text-black font-bold px-6 py-3 rounded-lg flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Agregar nueva mascota</span>
        </a>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.pets.index') }}" class="relative">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Buscar..." 
                   class="w-full max-w-md px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            <button type="submit" class="hidden">Buscar</button>
        </form>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Table -->
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
                    <td class="px-6 py-4 text-gray-900">{{ $pet->breed }}</td>
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

    <!-- Pagination -->
    @if($pets->hasPages())
    <div class="mt-6">
        {{ $pets->links() }}
    </div>
    @endif
</div>
@endsection
