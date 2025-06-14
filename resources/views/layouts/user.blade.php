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
<body class="font-sans antialiased">
    <div class="flex min-h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-amber-100 relative flex flex-col">
        <!-- Logo -->
        <div class="p-6 bg-pet-yellow-dark border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <img src="/images/sloganphoto.png" alt="Logo Pet Friendly" class="w-10 h-10 object-contain">
                <span class="text-xl font-bold text-gray-900">Pet Friendly</span>
            </div>
        </div>

        <!-- Navegación -->
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('user.profile') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-800 hover:bg-yellow-300 {{ request()->routeIs('user.profile') ? 'bg-yellow-300' : '' }}">
                <i class="fas fa-user"></i>
                <span>Perfil</span>
            </a>
            <a href="{{ route('user.pets.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-800 hover:bg-yellow-300 {{ request()->routeIs('user.pets.*') ? 'bg-yellow-300' : '' }}">
                <i class="fas fa-home"></i>
                <span>Ver Mascotas</span>
            </a>
            <a href="{{ route('user.donations.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-800 hover:bg-yellow-300 {{ request()->routeIs('user.donations.*') ? 'bg-yellow-300' : '' }}">
                <i class="fas fa-dollar-sign"></i>
                <span>Donaciones</span>
            </a>
        </nav>

        <!-- Botón de salida -->
        <div class="p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-3 px-4 py-3 text-gray-800 hover:bg-yellow-300 rounded-lg w-full">
                    <i class="fas fa-sign-out-alt"></i>
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

    <!-- Mensaje -->
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

    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
        <div id="modal-content" class="bg-white rounded-t-xl rounded-b-xl max-w-md w-full mx-4">
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
            
        // Close modal when clicking outside
        //document.getElementById('modal').addEventListener('click', function(e) {
        //    if (e.target === this) {
        //        closeModal();
        //    }
        //});
    </script>
</body>
</html>
