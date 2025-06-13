<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Pet Friendly</title>
    
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
        <div class="w-64 bg-white shadow-lg">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">PetFriendly</span>
                </div>
            </div>

            <!-- Navigation -->
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

            <!-- Logout Button -->
            <div class="absolute bottom-6 left-4 right-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg w-full">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Salir</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            @yield('content')
        </div>
    </div>
</body>
</html>
