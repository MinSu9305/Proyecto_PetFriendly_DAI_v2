@extends('layouts.admin')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Solicitudes de Adopción</h1>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.adoption-requests.index') }}" class="relative">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Buscar por nombre, email o mascota..." 
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

    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-pet-yellow">
                <tr>
                    <th class="px-6 py-4 text-left text-black font-bold">Nombre</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Apellido</th>
                    <th class="px-6 py-4 text-left text-black font-bold">DNI</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Celular</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Mascota</th>
                    <th class="px-6 py-4 text-center text-black font-bold">Estado</th>
                    <th class="px-6 py-4 text-center text-black font-bold">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($adoptionRequests as $request)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-900">{{ $request->user->name }}</td>
                    <td class="px-6 py-4 text-gray-900">{{ $request->user->name }}</td>
                    <td class="px-6 py-4 text-gray-900">12345678</td>
                    <td class="px-6 py-4 text-gray-900">965781234</td>
                    <td class="px-6 py-4 text-gray-900">{{ $request->pet->name }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $request->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $request->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $request->status_in_spanish }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('admin.adoption-requests.show', $request) }}" 
                               class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.adoption-requests.edit', $request) }}" 
                               class="p-2 text-green-600 hover:bg-green-100 rounded-lg" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        No se encontraron solicitudes de adopción.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($adoptionRequests->hasPages())
    <div class="mt-6">
        {{ $adoptionRequests->links() }}
    </div>
    @endif
</div>
@endsection
