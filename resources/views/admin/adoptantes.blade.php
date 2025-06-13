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
        .bg-pet-yellow {
            background-color: #FCD34D;
        }

        .hover\:bg-pet-yellow:hover {
            background-color: #F59E0B;
        }

        .text-pet-yellow {
            color: #F59E0B;
        }

        .bg-pet-yellow-dark {
            background-color: #F59E0B;
        }
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
                            <path
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">PetFriendly</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2">
                <!-- Adoptantes -->
                <a href="{{ route('admin.adoptantes') }}"
                    class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.adoptantes') ? 'bg-pet-yellow text-black font-semibold' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg">
                    <i class="fas fa-users"></i>
                    <span>Adoptantes</span>
                </a>

                <!-- Mascotas -->
                <a href="{{ route('admin.pets.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.pets.*') ? 'bg-pet-yellow text-black font-semibold' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg">
                    <i class="fas fa-paw"></i>
                    <span>Mascotas</span>
                </a>

                <!-- Solicitudes -->
                <a href="{{ route('admin.adoption-requests.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.adoption-requests.*') ? 'bg-pet-yellow text-black font-semibold' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg">
                    <i class="fas fa-file-alt"></i>
                    <span>Solicitudes</span>
                </a>

                <!-- Donaciones -->
                <a href="{{ route('admin.donations.index') }}"
                    class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.donations.*') ? 'bg-pet-yellow text-black font-semibold' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg">
                    <i class="fas fa-heart"></i>
                    <span>Donaciones</span>
                </a>

            </nav>

            <!-- Logout Button -->
            <div class="absolute bottom-6 left-4 right-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg w-full">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Salir</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Lista de Adoptantes</h1>
            </div>

            <!-- Search Bar -->
            <div class="mb-6">
                <form method="GET" action="{{ route('admin.adoptantes') }}" class="flex gap-4">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Buscar por nombre o correo..."
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    <button type="submit"
                        class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    @if ($search)
                        <a href="{{ route('admin.adoptantes') }}"
                            class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg">
                            Limpiar
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-pet-yellow">
                        <tr>
                            <th class="px-6 py-4 text-left text-black font-bold">Nombre</th>
                            <th class="px-6 py-4 text-left text-black font-bold">Correo</th>
                            <th class="px-6 py-4 text-center text-black font-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($adoptantes as $adoptante)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-900">{{ $adoptante->name }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ $adoptante->email }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button onclick="viewAdoptante({{ $adoptante->id }})"
                                            class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="editAdoptante({{ $adoptante->id }})"
                                            class="p-2 text-green-600 hover:bg-green-100 rounded-lg" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteAdoptante({{ $adoptante->id }})"
                                            class="p-2 text-red-600 hover:bg-red-100 rounded-lg" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    No se encontraron adoptantes.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($adoptantes->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $adoptantes->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal para ver detalles -->
    <div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        style="display: none;">
        <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Detalles del Adoptante</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="modalContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        function viewAdoptante(id) {
            fetch(`/admin/adoptantes/${id}/view`)
                .then(response => response.json())
                .then(data => {
                    const content = `
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-semibold text-gray-900">Información Personal</h4>
                                <p><strong>Nombre:</strong> ${data.user.name}</p>
                                <p><strong>Correo:</strong> ${data.user.email}</p>
                                <p><strong>Fecha de Nacimiento:</strong> ${data.user.birth_date}</p>
                                <p><strong>Registrado:</strong> ${new Date(data.user.created_at).toLocaleDateString()}</p>
                            </div>
                            
                            <div>
                                <h4 class="font-semibold text-gray-900">Solicitudes de Adopción</h4>
                                ${data.adoptionRequests.length > 0 ? 
                                    data.adoptionRequests.map(req => `
                                            <div class="border p-3 rounded">
                                                <p><strong>Mascota:</strong> ${req.pet.name}</p>
                                                <p><strong>Estado:</strong> ${req.status}</p>
                                                <p><strong>Mensaje:</strong> ${req.message || 'Sin mensaje'}</p>
                                            </div>
                                        `).join('') : 
                                    '<p class="text-gray-500">No tiene solicitudes de adopción</p>'
                                }
                            </div>
                            
                            <div>
                                <h4 class="font-semibold text-gray-900">Donaciones</h4>
                                ${data.donations.length > 0 ? 
                                    data.donations.map(don => `
                                            <div class="border p-3 rounded">
                                                <p><strong>Monto:</strong> S/ ${don.amount}</p>
                                                <p><strong>Estado:</strong> ${don.status}</p>
                                                <p><strong>Fecha:</strong> ${new Date(don.created_at).toLocaleDateString()}</p>
                                            </div>
                                        `).join('') : 
                                    '<p class="text-gray-500">No ha realizado donaciones</p>'
                                }
                            </div>
                        </div>
                    `;
                    document.getElementById('modalContent').innerHTML = content;
                    document.getElementById('viewModal').style.display = 'flex';
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cargar los detalles');
                });
        }

        function editAdoptante(id) {
            // Implementar edición
            alert('Función de edición en desarrollo');
        }

        function deleteAdoptante(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este adoptante?')) {
                fetch(`/admin/adoptantes/${id}/delete`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.error || 'Error al eliminar');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al eliminar el adoptante');
                    });
            }
        }

        function closeModal() {
            document.getElementById('viewModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('viewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>

</html>
