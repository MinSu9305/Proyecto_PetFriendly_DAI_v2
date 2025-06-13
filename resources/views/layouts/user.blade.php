<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Pet Friendly') }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .bg-pet-yellow { background-color: #FCD34D; }
        .hover\:bg-pet-yellow:hover { background-color: #F59E0B; }
        .text-pet-yellow { color: #F59E0B; }
        .bg-pet-yellow-dark { background-color: #F59E0B; }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-pet-yellow-dark">
            <!-- Logo -->
            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-black">PetFriendly</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2 bg-amber-100">
                <a href="{{ route('user.profile') }}" 
                   class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('user.profile') ? 'bg-white' : '' }} text-gray-700 hover:bg-white rounded-lg">
                    <i class="fas fa-user"></i>
                    <span>Perfil</span>
                </a>
                <a href="{{ route('user.pets.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('user.pets.*') ? 'bg-white' : '' }} text-gray-700 hover:bg-white rounded-lg">
                    <i class="fas fa-paw"></i>
                    <span>Ver Mascotas</span>
                </a>
                <a href="{{ route('user.donations.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('user.donations.*') ? 'bg-white' : '' }} text-gray-700 hover:bg-white rounded-lg">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Donaciones</span>
                </a>
            </nav>

            <!-- Logout Button -->
            <div class="absolute bottom-6 left-4 right-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-white rounded-lg w-full">
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

    <!-- Flash Messages -->
    @if (session('success'))
        <div id="success-message" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg z-50">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('success-message').style.display = 'none';
            }, 5000);
        </script>
    @endif

    @if (session('error'))
        <div id="error-message" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg z-50">
            {{ session('error') }}
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('error-message').style.display = 'none';
            }, 5000);
        </script>
    @endif

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
        <div id="modal-content" class="bg-white rounded-t-xl rounded-b-xl max-w-md w-full mx-4">
            <!-- Modal content will be inserted here -->
        </div>
    </div>

    <script>
        function showModal(title, content, actions) {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modal-content');
            
            let html = `
                <div class="bg-pet-yellow-dark px-4 py-3 flex justify-between items-center rounded-t-xl">
                    <h3 class="font-bold">${title}</h3>
                    <button onclick="closeModal()" class="text-black">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6 text-center">
                    <p class="text-xl font-bold mb-6">${content}</p>
                    <div class="flex justify-center space-x-4">
                        ${actions}
                    </div>
                </div>
            `;
            
            modalContent.innerHTML = html;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        
        function showMessage(title, content) {
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modal-content');
            
            let html = `
                <div class="bg-pet-yellow-dark px-4 py-3 flex justify-between items-center rounded-t-xl">
                    <h3 class="font-bold">${title}</h3>
                    <button onclick="closeModal()" class="text-black">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6 text-center">
                    <p class="text-xl font-bold">${content}</p>
                </div>
            `;
            
            modalContent.innerHTML = html;
            modal.classList.remove('hidden');
        }
        function closeModal() {
            const modal = document.getElementById('modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        }
        
        // Close modal when clicking outside
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
