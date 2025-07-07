<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PetFriendly - Gestión de Especies</title>
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
        <!-- Sidebar -->
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
                    class="flex items-center space-x-3 px-4 py-3 bg-pet-yellow text-black font-semibold rounded-lg"> <!-- En cada uno debe ser diferente para se haga clic entonces este se mantega amarillo mietras se navega dentro de el -->
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
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Gestión de Especies</h1>
            </div>

            <!-- Mensajes de éxito/error -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Barra de búsqueda y botón agregar -->
            <div class="mb-6 flex justify-between items-center">
                <form method="GET" action="{{ route('admin.especies.index') }}" class="flex gap-4">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Buscar por especie..."
                        class="w-96 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    <button type="submit"
                        class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    @if ($search)
                        <a href="{{ route('admin.especies.index') }}"
                            class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg">
                            Limpiar
                        </a>
                    @endif
                </form>
                
                <a href="{{ route('admin.especies.create') }}"
                    class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                    <i class="fas fa-plus"></i> Agregar nueva especie
                </a>
            </div>

            <!-- Tabla simplificada -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-pet-yellow">
            <tr>
                <th class="px-6 py-4 text-left text-black font-bold">Especie</th>
                <th class="px-6 py-4 text-left text-black font-bold">Descripción</th>
                <th class="px-6 py-4 text-center text-black font-bold">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($especies as $especie)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $especie->nombre }}</td>
                    <td class="px-6 py-4 text-gray-900">{{ Str::limit($especie->descripcion, 80) }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('admin.especies.edit', $especie) }}" 
                               class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" 
                               title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($especie->razas_count == 0 && $especie->mascotas_count == 0)
                                <form action="{{ route('admin.especies.destroy', $especie) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('¿Estás seguro de eliminar esta especie?')">
                                    @csrf
                                    @method('DELETE')
                                    <!--
                                    <button type="submit" 
                                            class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors" 
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                -->
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                        No se encontraron especies.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
            <!-- Paginación -->
            @if ($especies->hasPages())
                <div class="mt-6 flex justify-center items-center">
                    <div class="flex items-center gap-2 bg-white rounded-lg shadow-sm p-2">
                        {{-- Previous Page Link --}}
                        @if ($especies->onFirstPage())
                            <span class="px-3 py-1 rounded-md text-gray-400 cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $especies->previousPageUrl() }}" 
                               class="px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-pet-yellow hover:text-black transition-colors">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($especies->getUrlRange(1, $especies->lastPage()) as $page => $url)
                            @if ($page == $especies->currentPage())
                                <span class="px-3 py-1 rounded-md bg-pet-yellow text-black font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" 
                                   class="px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-pet-yellow hover:text-black transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($especies->hasMorePages())
                            <a href="{{ $especies->nextPageUrl() }}" 
                               class="px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-pet-yellow hover:text-black transition-colors">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="px-3 py-1 rounded-md text-gray-400 cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>