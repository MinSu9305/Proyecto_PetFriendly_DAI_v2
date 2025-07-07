@extends('layouts.user')

@section('content')
    <div class="p-8">
        <h1 class="text-4xl font-bold mb-8">Mi Perfil</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Información personal -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <!-- Foto a la izquierda -->
                    <div class="relative">
                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                            class="w-32 h-32 rounded-full object-cover">
                    </div>

                    <!-- Botón a la derecha -->
                    <div>
                        <button onclick="document.getElementById('photo-upload').click()"
                            class="ml-4 px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                            Cambiar foto
                        </button>
                        <form id="photo-form" action="{{ route('user.profile.update-photo') }}" method="POST"
                            enctype="multipart/form-data" class="hidden">
                            @csrf
                            <input type="file" id="photo-upload" name="photo"
                                onchange="document.getElementById('photo-form').submit()">
                        </form>
                    </div>
                </div>


                <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <div class="flex">
                            <input type="text" name="name" value="{{ $user->name }}"
                                class="flex-grow px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            <button type="submit" class="ml-2 px-3 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                                Editar
                            </button>
                        </div>
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                        <div class="flex">
                            <input type="email" name="email" value="{{ $user->email }}"
                                class="flex-grow px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            <button type="submit" class="ml-2 px-3 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                                Editar
                            </button>
                        </div>
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Nacimiento</label>
                        <p class="px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-700">
                            {{ $user->birth_date ? $user->birth_date->format('d/m/Y') : 'No especificada' }}
                        </p>
                    </div>

                </form>
            </div>

            <!-- Historial -->
            <div class="space-y-6">
                <!-- Solicitudes realizadas -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">Solicitudes realizadas</h2>

                    @if ($adoptionRequests->count() > 0)
                        <div class="space-y-2">
                            @foreach ($adoptionRequests as $request)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold">Solicitud de Adopción de {{ $request->pet->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $request->created_at->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <div>
                                            @if ($request->status === 'approved')
                                                <span
                                                    class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                                    Aprobado
                                                </span>
                                            @elseif($request->status === 'rejected')
                                                <span
                                                    class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                                    Rechazado
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                                    En revisión
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No has realizado solicitudes de adopción.</p>
                    @endif
                </div>

                <!-- Donaciones realizadas -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">Donaciones realizadas</h2>

                    @if ($donations->count() > 0)
                        <div class="space-y-2">
                            @foreach ($donations as $donation)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold">Donación
                                                #{{ str_pad($donation->id, 4, '0', STR_PAD_LEFT) }}</p>
                                            <p class="text-sm text-gray-500">{{ $donation->created_at->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="font-semibold">S/.
                                                {{ number_format($donation->amount, 2) }}</span>
                                            <a href="{{ route('user.donations.certificate', $donation) }}" 
                                                class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                                                <i class="fas fa-download mr-2"></i>
                                                Descargar
                                            </a>
                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No has realizado donaciones.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
