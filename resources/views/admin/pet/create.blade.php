@extends('layouts.admin')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="flex items-center mb-8">
        <a href="{{ route('admin.pets.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Agregar Nueva Mascota</h1>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.pets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Edad -->
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Edad</label>
                    <input type="number" name="age" id="age" value="{{ old('age') }}" min="0" max="20"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    @error('age') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Especie -->
                <div>
                    <label for="especie_id" class="block text-sm font-medium text-gray-700 mb-1">Especie</label>
                    <select name="especie_id" id="especie_id" onchange="loadRazas()"
                             class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        <option value="">Seleccionar...</option>
                        @foreach($especies as $especie)
                            <option value="{{ $especie->id }}" {{ old('especie_id') == $especie->id ? 'selected' : '' }}>
                                {{ $especie->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('especie_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Sexo -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Sexo</label>
                    <select name="gender" id="gender"
                             class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        <option value="">Seleccionar...</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Macho</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Hembra</option>
                    </select>
                    @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Raza -->
                <div>
                    <label for="raza_id" class="block text-sm font-medium text-gray-700 mb-1">Raza</label>
                    <select name="raza_id" id="raza_id"
                             class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        <option value="">Seleccionar raza...</option>
                        <!-- Las opciones se cargarán dinámicamente -->
                    </select>
                    @error('raza_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Tamaño -->
                <div>
                    <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Tamaño</label>
                    <select name="size" id="size"
                             class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        <option value="">Seleccionar...</option>
                        <option value="small" {{ old('size') == 'small' ? 'selected' : '' }}>Pequeño</option>
                        <option value="medium" {{ old('size') == 'medium' ? 'selected' : '' }}>Mediano</option>
                        <option value="large" {{ old('size') == 'large' ? 'selected' : '' }}>Grande</option>
                    </select>
                    @error('size') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Estado -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="status" id="status"
                             class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="adopted" {{ old('status') == 'adopted' ? 'selected' : '' }}>Adoptado</option>
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
                    
                    <div id="preview-container" class="mt-4 hidden">
                        <img id="preview-image" src="/placeholder.svg"
                              class="w-32 h-32 object-cover rounded-lg mx-auto">
                    </div>
                </div>
                @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Descripción -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="description" id="description" rows="4"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Botones -->
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

    function loadRazas() {
        const especieSelect = document.getElementById('especie_id');
        const razaSelect = document.getElementById('raza_id');
        const selectedEspecie = especieSelect.value;
        const currentRazaId = '{{ old("raza_id") }}'; // Solo old() para create
        
        // Limpiar opciones de raza
        razaSelect.innerHTML = '<option value="">Cargando razas...</option>';
        
        if (!selectedEspecie) {
            razaSelect.innerHTML = '<option value="">Primero selecciona una especie...</option>';
            return;
        }
        
        // Hacer petición AJAX para obtener razas
        fetch(`{{ route('admin.pets.razas-by-especie') }}?especie_id=${selectedEspecie}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                razaSelect.innerHTML = '<option value="">Seleccionar raza...</option>';
                
                if (data && data.length > 0) {
                    data.forEach(raza => {
                        const option = document.createElement('option');
                        option.value = raza.id;
                        option.textContent = raza.nombre;
                        
                        // Mantener selección si hay old() data
                        if (currentRazaId == raza.id) {
                            option.selected = true;
                        }
                        
                        razaSelect.appendChild(option);
                    });
                } else {
                    razaSelect.innerHTML = '<option value="">No hay razas disponibles para esta especie</option>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                razaSelect.innerHTML = '<option value="">Error al cargar razas</option>';
            });
    }

    // Cargar razas al cargar la página si hay una especie seleccionada (por old() data)
    document.addEventListener('DOMContentLoaded', function() {
        const especieSelect = document.getElementById('especie_id');
        if (especieSelect.value) {
            loadRazas();
        }
    });
</script>
@endsection