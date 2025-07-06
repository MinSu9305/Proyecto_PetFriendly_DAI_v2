<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PetFriendly - Panel de Administración</title>
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
        <div class="w-64 bg-white shadow-lg relative">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <img src="/images/sloganphoto.png" alt="Logo Pet Friendly" class="w-10 h-10 object-contain">
                    <span class="text-xl font-bold text-gray-900">Pet Friendly</span>
                </div>
            </div>

            <!-- Navegacion -->
            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.adoptantes') }}" 
                   class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.adoptantes') ? 'bg-gray-100' : '' }} text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-users"></i>
                    <span>Adoptantes</span>
                </a>
                <a href="{{ route('admin.pets.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.pets.*') ? 'bg-pet-yellow text-black' : 'text-gray-700' }} hover:bg-gray-100 rounded-lg font-semibold">
                    <i class="fas fa-paw"></i>
                    <span>Mascotas</span>
                </a>

                <a href="{{ route('admin.razas.index') }}"
                    class ="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.razas.*') ? 'bg-pet-yellow text-black font-semibold' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg">
                    <i class="fas fa-dna"></i>
                    <span>Razas</span>
                </a>

                <a href="{{ route('admin.adoption-requests.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.adoption-requests.*') ? 'bg-pet-yellow text-black' : 'text-gray-700' }} hover:bg-gray-100 rounded-lg font-semibold">
                    <i class="fas fa-file-alt"></i>
                    <span>Solicitudes</span>
                </a>
                <a href="{{ route('admin.donations.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.donations.*') ? 'bg-pet-yellow text-black' : 'text-gray-700' }} hover:bg-gray-100 rounded-lg font-semibold">
                    <i class="fas fa-heart"></i>
                    <span>Donaciones</span>
                </a>
            </nav>

            <!-- Boton de salir -->
            <!-- Boton para salir -->
            <div class="absolute bottom-6 left-0 right-0 px-4">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" 
                        onclick="this.disabled=true; this.form.submit();" 
                        class="flex items-center space-x-3 px-4 py-3 bg-black text-white rounded-lg transition-colors duration-200 font-medium w-full">
                        <i class="fas fa-sign-out-alt w-5 text-center text-white"></i>
                        <span>Salir</span>
                    </button>
                </form>
            </div> 
        </div>

        <!-- Contenido -->
        <div class="flex-1">
            @yield('content')
        </div>
    </div>
</body>
</html>
