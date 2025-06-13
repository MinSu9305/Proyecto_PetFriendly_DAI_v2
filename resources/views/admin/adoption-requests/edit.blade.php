@extends('layouts.admin')

@section('content')
    <div class="p-8">
        <!-- Header -->
        <div class="flex items-center mb-8">
            <a href="{{ route('admin.adoption-requests.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Editar Solicitud de Adopción</h1>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.adoption-requests.update', $adoptionRequest) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Adoptante -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Adoptante</label>
                        <div class="bg-gray-100 p-2 rounded-lg border border-gray-300">
                            {{ $adoptionRequest->user->name }} ({{ $adoptionRequest->user->email }})
                        </div>
                        <input type="hidden" name="user_id" value="{{ $adoptionRequest->user_id }}">

                        @error('user_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Mascota -->
                    <div>
                        <label for="pet_id" class="block text-sm font-medium text-gray-700 mb-1">Mascota</label>
                        <div class="bg-gray-100 p-2 rounded-lg border border-gray-300">
                            {{ $adoptionRequest->pet->name }} ({{ $adoptionRequest->pet->type_in_spanish }},
                            {{ $adoptionRequest->pet->breed }})
                        </div>
                        <input type="hidden" name="pet_id" value="{{ $adoptionRequest->pet_id }}">

                        @error('pet_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="status" id="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            <option value="pending"
                                {{ old('status', $adoptionRequest->status) == 'pending' ? 'selected' : '' }}>Pendiente
                            </option>
                            <option value="approved"
                                {{ old('status', $adoptionRequest->status) == 'approved' ? 'selected' : '' }}>Aprobada
                            </option>
                            <option value="rejected"
                                {{ old('status', $adoptionRequest->status) == 'rejected' ? 'selected' : '' }}>Rechazada
                            </option>
                        </select>
                        @error('status')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Motivo de adopción -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Motivo de la Adopción</label>
                    <div class="bg-gray-100 p-3 rounded-lg border border-gray-300 text-gray-700">
                        {{ $adoptionRequest->message }}
                    </div>
                    <input type="hidden" name="message" value="{{ $adoptionRequest->message }}">

                    @error('message')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Notas del administrador -->
                <div>
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-1">Notas del
                        Administrador</label>
                    <textarea name="admin_notes" id="admin_notes" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">{{ old('admin_notes', $adoptionRequest->admin_notes) }}</textarea>
                    @error('admin_notes')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4 pt-4">
                    <a href="{{ route('admin.adoption-requests.index') }}"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
