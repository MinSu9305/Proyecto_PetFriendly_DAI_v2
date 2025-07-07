@extends('layouts.admin')

@section('content')
<div class="p-8 max-w-6xl mx-auto">
   
    <!-- Botón volver -->
    <div class="mb-5">
        <a href="{{ route('admin.pets.index') }}" 
            class="inline-flex items-center px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-700 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver
        </a>
    </div>

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Agregar nueva mascota</h1>
    </div>

    <!-- Formulario con 2 columnas principales -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <form action="{{ route('admin.pets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col md:flex-row">
                <!-- Columna izquierda - Campos del formulario -->
                <div class="w-full md:w-2/3 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Edad -->
                        <div>
                            <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Edad (años)</label>
                            <input type="number" name="age" id="age" value="{{ old('age') }}" min="0" max="20"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            @error('age') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Especie -->
                        <div>
                            <label for="especie_id" class="block text-sm font-medium text-gray-700 mb-1">Especie</label>
                            <select name="especie_id" id="especie_id" onchange="loadRazas()"
                                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                                <option value="">Seleccionar...</option>
                                @foreach($especies as $especie)
                                    <option value="{{ $especie->id }}" {{ old('especie_id') == $especie->id ? 'selected' : '' }}>
                                        {{ $especie->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('especie_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Raza -->
                        <div>
                            <label for="raza_id" class="block text-sm font-medium text-gray-700 mb-1">Raza</label>
                            <select name="raza_id" id="raza_id"
                                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                                <option value="">Seleccionar raza...</option>
                            </select>
                            @error('raza_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Sexo -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Sexo</label>
                            <select name="gender" id="gender"
                                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                                <option value="">Seleccionar...</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Macho</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Hembra</option>
                            </select>
                            @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tamaño -->
                        <div>
                            <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Tamaño</label>
                            <select name="size" id="size"
                                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
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
                                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="adopted" {{ old('status') == 'adopted' ? 'selected' : '' }}>Adoptado</option>
                            </select>
                            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="description" id="description" rows="4"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">{{ old('description') }}</textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('admin.pets.index') }}"
                            class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                                 class="px-6 py-2 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold rounded-lg shadow-sm transition-colors">
                            Guardar Mascota
                        </button>
                    </div>
                </div>

<!-- Área de foto CORREGIDA Y FUNCIONAL -->
<div class="w-full md:w-1/3 bg-white p-6 border-l border-gray-200">
    <div class="sticky top-6">
        <label class="block text-sm font-medium text-gray-700 mb-3">Foto de la mascota</label>
        
        <!-- Contenedor principal (no es el label directamente) -->
        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-gray-400 transition-colors h-64 relative">
            <!-- Input file oculto -->
            <input type="file" name="photo" id="photo" accept="image/*" class="hidden" onchange="showPreview(event)">
            
            <!-- Label que activa el input -->
            <label for="photo" class="absolute inset-0 flex flex-col items-center justify-center cursor-pointer">
                <!-- Estado inicial (sin foto) -->
                <div id="upload-prompt">
                    <i class="fas fa-camera text-4xl text-gray-400 mb-3"></i>
                    <p class="text-gray-600">Haz clic para subir una imagen</p>
                    <p class="text-sm text-gray-500 mt-1">PNG, JPG hasta 2MB</p>
                </div>
                
                <!-- Vista previa -->
                <img id="preview-image" class="w-full h-full object-cover rounded-lg hidden">
            </label>
            
            <!-- Botón para cambiar (solo visible cuando hay foto) -->
            <div id="change-button" class="absolute bottom-3 left-0 right-0 hidden">
                <button type="button" onclick="document.getElementById('photo').click()" 
                        class="bg-black bg-opacity-50 text-white px-3 py-1 rounded-full text-sm hover:bg-opacity-70 transition">
                    <i class="fas fa-sync-alt mr-1"></i> Cambiar foto
                </button>
            </div>
        </div>
        @error('photo') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
    </div>
</div>
            </div>
        </form>
    </div>
</div>

<script>
    function showPreview(event) {
        const file = event.target.files[0];
        const previewImage = document.getElementById('preview-image');
        const uploadPrompt = document.getElementById('upload-prompt');
        const changeButton = document.getElementById('change-button');
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                // Mostrar la imagen subida
                previewImage.src = e.target.result;
                previewImage.classList.remove('hidden');
                
                // Ocultar el mensaje de subida
                uploadPrompt.classList.add('hidden');
                
                // Mostrar botón de cambio
                changeButton.classList.remove('hidden');
            }
            
            reader.readAsDataURL(file);
        }
    }

    // Opcional: Hacer que hacer clic en la imagen también permita cambiarla
    document.addEventListener('DOMContentLoaded', function() {
        const previewImage = document.getElementById('preview-image');
        if (previewImage) {
            previewImage.addEventListener('click', function() {
                document.getElementById('photo').click();
            });
        }
    });


    function loadRazas() {
        const especieSelect = document.getElementById('especie_id');
        const razaSelect = document.getElementById('raza_id');
        const selectedEspecie = especieSelect.value;
        const currentRazaId = '{{ old("raza_id") }}';
        
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