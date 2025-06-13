@extends('layouts.user')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold">Mis Donaciones</h1>
        <a href="{{ route('user.donations.create') }}" class="px-6 py-3 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
            Realizar Donación
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        @if($donations->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="px-4 py-2 text-left">#</th>
                            <th class="px-4 py-2 text-left">Fecha</th>
                            <th class="px-4 py-2 text-left">Monto</th>
                            <th class="px-4 py-2 text-center">Comprobante</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donations as $donation)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-4">{{ $loop->iteration }}</td>
                                <td class="px-4 py-4">{{ $donation->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-4">S/. {{ number_format($donation->amount, 2) }}</td>
                                <td class="px-4 py-4 text-center">
                                    <a href="{{ route('user.donations.certificate', $donation) }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="mt-4">
                {{ $donations->links() }}
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No has realizado donaciones aún.</p>
        @endif
    </div>
</div>
@endsection
