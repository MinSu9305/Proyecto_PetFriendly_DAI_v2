<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PetFriendly - Agregar Especie</title>
    <link rel="icon" href="/images/LogoPag.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        .bg-pet-yellow { background-color: #FCD34D; }
        .hover\:bg-pet-yellow:hover { background-color: #F59E0B; }
        .text-pet-yellow { color: #F59E0B; }
        .bg-pet-yellow-dark { background-color: #F59E0B; }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar (igual que en index) -->
        <div class="w-64 bg-black shadow-lg relative">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <img src="/images/icono.png" alt="Logo Pet Friendly" class="w-10 h-10 object-contain">
                    <div class="flex flex-col"> <!-- Contenedor para texto en columna -->
                        <span class="text-xl font-bold text-white">Pet Friendly</span>
                        <span class="text-sm text-gray-300">Administrador</span> <!-- Texto añadido -->
                    </div>
                </div>
            </div>


            <!-- Navegación -->
            <nav class="p-4 space-y-2">
                <!-- Adoptantes -->
                <a href="{{ route('admin.adoptantes') }}"
                    class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-yellow-100 hover:bg-opacity-50 rounded-lg">
                    <i class="fas fa-users"></i>
                    <span>Adoptantes</span>
                </a>

                <!-- Mascotas -->
                <a href="{{ route('admin.pets.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-yellow-100 hover:bg-opacity-50 rounded-lg">
                    <i class="fas fa-paw"></i>
                    <span>Mascotas</span>
                </a>

                <!-- Especies -->
                <a href="{{ route('admin.especies.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 bg-pet-yellow text-black font-semibold rounded-lg">
                    <i class="fas fa-layer-group"></i>
                    <span>Especies</span>
                </a>

                <!-- Razas -->
                <a href="{{ route('admin.razas.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-yellow-100 hover:bg-opacity-50 rounded-lg">
                    <i class="fas fa-dna"></i>
                    <span>Razas</span>
                </a>

                <!-- Solicitudes -->
                <a href="{{ route('admin.adoption-requests.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-yellow-100 hover:bg-opacity-50 rounded-lg">
                    <i class="fas fa-file-alt"></i>
                    <span>Solicitudes</span>
                </a>

                <!-- Donaciones -->
                <a href="{{ route('admin.donations.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-yellow-100 hover:bg-opacity-50 rounded-lg">
                    <i class="fas fa-heart"></i>
                    <span>Donaciones</span>
                </a>
            </nav>

            <!-- Botón para salir -->
            <!-- Botón Salir editado -->
            <div class="absolute bottom-6 left-0 right-0 px-4">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" 
                        onclick="this.disabled=true; this.form.submit();" 
                        class="flex items-center space-x-3 px-4 py-3 bg-pet-yellow text-black rounded-lg transition-colors duration-200 font-medium w-full">
                        <i class="fas fa-sign-out-alt w-5 text-center text-black"></i>
                        <span>Salir</span>
                    </button>
                </form>
            </div>  
        </div>

<!-- Contenido principal -->
<div class="flex-1 p-8">
    <!-- Botón volver -->
    <div class="mb-6">
        <a href="{{ route('admin.especies.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-700 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver
        </a>
    </div>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Agregar Especie</h1>
    </div>

    <!-- Contenedor flexible para formulario y sección informativa -->
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow p-6 lg:w-2/3">
            <form action="{{ route('admin.especies.store') }}" method="POST">
                @csrf
                
                <!-- Nombre de la especie -->
                <div class="mb-6">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre de la especie <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none @error('nombre') border-red-500 @enderror"
                           placeholder="Ej: Perro, Gato, Conejo" required>
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="mb-6">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                        Descripción
                    </label>
                    <textarea name="descripcion" id="descripcion" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none @error('descripcion') border-red-500 @enderror"
                              placeholder="Describe las características generales de esta especie...">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex gap-4">
                    <button type="submit"
                            class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                        <i class="fas fa-save mr-2"></i>
                        Guardar
                    </button>
                    <a href="{{ route('admin.especies.index') }}"
                       class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- Sección informativa -->
        <div class="lg:w-1/3">
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg h-full">
                <h3 class="font-bold text-lg text-yellow-700 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i> Guía rápida
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <h4 class="font-medium text-gray-800 mb-2">¿Qué es una especie?</h4>
                        <p class="text-sm text-gray-600">Una especie agrupa animales con características biológicas similares. Ejemplos comunes:</p>
                    </div>
                    
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <span class="bg-yellow-100 text-yellow-700 rounded-full p-1 mr-3">
                                <i class="fas fa-dog text-sm"></i>
                            </span>
                            <span class="text-sm">Perro (Canis lupus familiaris)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-yellow-100 text-yellow-700 rounded-full p-1 mr-3">
                                <i class="fas fa-cat text-sm"></i>
                            </span>
                            <span class="text-sm">Gato (Felis catus)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="bg-yellow-100 text-yellow-700 rounded-full p-1 mr-3">
                                <i class="fas fa-dove text-sm"></i>
                            </span>
                            <span class="text-sm">Loro (Psittaciformes)</span>
                        </li>
                    </ul>
                    
                    <div class="p-3 bg-white rounded border border-yellow-200">
                        <p class="text-xs font-medium text-yellow-700 mb-1">CONSEJO:</p>
                        <p class="text-xs text-gray-700">Usa nombres comunes pero precisos. Evita nombres demasiado técnicos o genéricos.</p>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>