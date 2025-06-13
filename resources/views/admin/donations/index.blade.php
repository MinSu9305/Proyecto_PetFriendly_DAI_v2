@extends('layouts.admin')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Donaciones</h1>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.donations.index') }}" class="relative">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Buscar por nombre, email o monto..." 
                   class="w-full max-w-md px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            <button type="submit" class="hidden">Buscar</button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-pet-yellow">
                <tr>
                    <th class="px-6 py-4 text-left text-black font-bold">Nombre</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Apellido</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Monto</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Fecha</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Hora</th>
                    <th class="px-6 py-4 text-center text-black font-bold">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($donations as $donation)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-900">{{ explode(' ', $donation->donor_name)[0] ?? $donation->donor_name }}</td>
                    <td class="px-6 py-4 text-gray-900">{{ explode(' ', $donation->donor_name)[1] ?? '' }}</td>
                    <td class="px-6 py-4 text-gray-900">{{ number_format($donation->amount, 2) }}</td>
                    <td class="px-6 py-4 text-gray-900">{{ $donation->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-gray-900">{{ $donation->created_at->format('H:i') }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('admin.donations.show', $donation) }}" 
                               class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        No se encontraron donaciones.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($donations->hasPages())
    <div class="mt-6">
        {{ $donations->links() }}
    </div>
    @endif
</div>
@endsection
