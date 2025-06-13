@extends('layouts.admin')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="flex items-center mb-8">
        <a href="{{ route('admin.pets.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Editar Mascota</h1>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.pets.update', $pet) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $pet->name) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Edad -->
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Edad</label>
                    <input type="number" name="age" id="age" value="{{ old('age', $pet->age) }}" min="0" max="20"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    @error('age') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Especie -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Especie</label>
                    <select name="type" id="type" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        <option value="">Seleccionar...</option>
                        <option value="dog" {{ old('type', $pet->type) == 'dog' ? 'selected' : '' }}>Perro</option>
                        <option value="cat" {{ old('type', $pet->type) == 'cat' ? 'selected' : '' }}>Gato</option>
                        <option value="other" {{ old('type', $pet->type) == 'other' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Sexo -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Sexo</label>
                    <select name="gender" id="gender" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        <option value="">Seleccionar...</option>
                        <option value="male" {{ old('gender', $pet->gender) == 'male' ? 'selected' : '' }}>Macho</option>
                        <option value="female" {{ old('gender', $pet->gender) == 'female' ? 'selected' : '' }}>Hembra</option>
                    </select>
                    @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Raza -->
                <div>
                    <label for="breed" class="block text-sm font-medium text-gray-700 mb-1">Raza</label>
                    <input type="text" name="breed" id="breed" value="{{ old('breed', $pet->breed) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    @error('breed') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Tamaño -->
                <div>
                    <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Tamaño</label>
                    <select name="size" id="size" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        <option value="">Seleccionar...</option>
                        <option value="small" {{ old('size', $pet->size) == 'small' ? 'selected' : '' }}>Pequeño</option>
                        <option value="medium" {{ old('size', $pet->size) == 'medium' ? 'selected' : '' }}>Mediano</option>
                        <option value="large" {{ old('size', $pet->size) == 'large' ? 'selected' : '' }}>Grande</option>
                    </select>
                    @error('size') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Estado -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="status" id="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        <option value="available" {{ old('status', $pet->status) == 'available' ? 'selected' : '' }}>Disponible</option>
                        <option value="pending" {{ old('status', $pet->status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="adopted" {{ old('status', $pet->status) == 'adopted' ? 'selected' : '' }}>Adoptado</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Subir Foto -->
            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Subir Foto</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                    <input type="file" name="photo" id="photo" accept="image/*" class="hidden" onchange="showPreview(event)">
                    <label for="photo" class="cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600">Haz clic para subir una imagen</p>
                        <p class="text-sm text-gray-500">PNG, JPG hasta 2MB</p>
                    </label>
                    
                    <div id="preview-container" class="mt-4 {{ $pet->images && count($pet->images) > 0 ? '' : 'hidden' }}">
                        <img id="preview-image" src="{{ $pet->images && count($pet->images) > 0 ? Storage::url($pet->images[0]) : '' }}" 
                             class="w-32 h-32 object-cover rounded-lg mx-auto">
                    </div>
                </div>
                @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Descripción -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="description" id="description" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">{{ old('description', $pet->description) }}</textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Checkboxes -->
            <div class="grid grid-cols-2 gap-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_vaccinated" id="is_vaccinated" value="1" {{ old('is_vaccinated', $pet->is_vaccinated) ? 'checked' : '' }} class="mr-2">
                    <label for="is_vaccinated" class="text-sm text-gray-700">Vacunado</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_sterilized" id="is_sterilized" value="1" {{ old('is_sterilized', $pet->is_sterilized) ? 'checked' : '' }} class="mr-2">
                    <label for="is_sterilized" class="text-sm text-gray-700">Esterilizado</label>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('admin.pets.index') }}" 
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

<script>
    function showPreview(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('preview-container').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
