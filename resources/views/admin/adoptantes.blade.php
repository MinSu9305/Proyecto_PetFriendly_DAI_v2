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
                    <img src="/images/sloganphoto.png" alt="Logo Pet Friendly" class="w-10 h-10 object-contain">
                    <span class="text-xl font-bold text-gray-900">Pet Friendly</span>
                </div>
            </div>

            <!-- Navegacion -->
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

                <!-- Razas -->
                <a href="{{ route('admin.razas.index') }}"
                    class ="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('admin.razas.*') ? 'bg-pet-yellow text-black font-semibold' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg">
                    <i class="fas fa-dna"></i>
                    <span>Razas</span>
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

            <!-- Boton para salir -->
            <div class="absolute bottom-6 left-4 right-4">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" 
                        onclick="this.disabled=true; this.form.submit();" 
                        class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg w-full">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Salir</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="flex-1 p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Lista de Adoptantes</h1>
            </div>

            <!-- Barra de Busqueda -->
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

            <!-- Tabla -->
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
                                                class="p-2 text-gray-700 hover:text-black hover:bg-gray-200 rounded-lg transition-colors" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <!--<button onclick="editAdoptante({{ $adoptante->id }})"
                                            class="p-2 text-green-600 hover:bg-green-100 rounded-lg" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteAdoptante({{ $adoptante->id }})"
                                            class="p-2 text-red-600 hover:bg-red-100 rounded-lg" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>-->
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

<!-- Paginacion de adoptantes-->
@if ($adoptantes->hasPages())
    <div class="mt-6 flex justify-center items-center">
        <div class="flex items-center gap-2 bg-white rounded-lg shadow-sm p-2">
            {{-- Previous Page Link --}}
            @if ($adoptantes->onFirstPage())
                <span class="px-3 py-1 rounded-md text-gray-400 cursor-not-allowed">
                    <i class="fas fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $adoptantes->previousPageUrl() }}" 
                   class="px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-pet-yellow hover:text-black transition-colors">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($adoptantes->getUrlRange(1, $adoptantes->lastPage()) as $page => $url)
                @if ($page == $adoptantes->currentPage())
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
            @if ($adoptantes->hasMorePages())
                <a href="{{ $adoptantes->nextPageUrl() }}" 
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

<!-- Modal para ver detalles -->
<div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
    <div class="bg-white rounded-lg p-0 max-w-2xl w-full mx-4 max-h-[90vh] overflow-hidden shadow-2xl">
        <!-- Encabezado con fondo amarillo -->
        <div class="bg-yellow-500 px-6 py-4 flex justify-between items-center">
            <h3 class="text-2xl font-bold text-gray-900">Detalles del Adoptante</h3>
            <button onclick="closeModal()" class="text-gray-900 hover:text-black transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Contenido del modal -->
        <div id="modalContent" class="p-6 overflow-y-auto" style="max-height: calc(90vh - 72px);">
            <!-- El contenido se llenará dinámicamente -->
        </div>
    </div>
</div>

<script>
    function viewAdoptante(id) {
        fetch(`/admin/adoptantes/${id}/view`)
            .then(response => response.json())
            .then(data => {
                const content = `
                    <!-- Tarjeta de información principal -->
                    <div class="bg-gray-50 rounded-lg p-5 mb-6 border border-gray-200">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="bg-yellow-100 text-yellow-800 rounded-full w-12 h-12 flex items-center justify-center">
                                <i class="fas fa-user text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">${data.user.name}</h2>
                                <p class="text-gray-600">${data.user.email}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Fecha de Nacimiento</label>
                                <p class="text-gray-900">${formatDate(data.user.birth_date)}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Registrado el</label>
                                <p class="text-gray-900">${new Date(data.user.created_at).toLocaleDateString()}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sección de Solicitudes -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-paw text-yellow-500 mr-2"></i>
                                Solicitudes de Adopción
                            </h4>
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">${data.adoptionRequests.length}</span>
                        </div>
                        
                        ${data.adoptionRequests.length > 0 ? 
                            `<div class="space-y-3">${data.adoptionRequests.map(req => `
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-yellow-300 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h5 class="font-medium text-gray-900">${req.pet.name}</h5>
                                            <span class="text-xs px-2 py-1 rounded-full ${getStatusColorClass(req.status)}">
                                                ${req.status}
                                            </span>
                                        </div>
                                        <span class="text-xs text-gray-500">${new Date(req.created_at).toLocaleDateString()}</span>
                                    </div>
                                    ${req.message ? `
                                    <div class="mt-2 pt-2 border-t border-gray-100">
                                        <p class="text-sm text-gray-600">${req.message}</p>
                                    </div>
                                    ` : ''}
                                </div>
                            `).join('')}</div>` : 
                            `<div class="text-center py-6 bg-gray-50 rounded-lg">
                                <i class="fas fa-inbox text-gray-300 text-3xl mb-2"></i>
                                <p class="text-gray-500">No hay solicitudes de adopción</p>
                            </div>`
                        }
                    </div>
                    
                    <!-- Sección de Donaciones -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-hand-holding-heart text-yellow-500 mr-2"></i>
                                Historial de Donaciones
                            </h4>
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">${data.donations.length}</span>
                        </div>
                        
                        ${data.donations.length > 0 ? 
                            `<div class="space-y-3">${data.donations.map(don => `
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-yellow-300 transition-colors">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h5 class="font-medium text-gray-900">Donación #${don.id}</h5>
                                            <span class="text-xs px-2 py-1 rounded-full ${getStatusColorClass(don.status)}">
                                                ${don.status}
                                            </span>
                                        </div>
                                        <span class="text-lg font-bold text-yellow-600">S/ ${don.amount}</span>
                                    </div>
                                    <div class="mt-2 pt-2 border-t border-gray-100 text-sm text-gray-600">
                                        ${new Date(don.created_at).toLocaleDateString()}
                                    </div>
                                </div>
                            `).join('')}</div>` : 
                            `<div class="text-center py-6 bg-gray-50 rounded-lg">
                                <i class="fas fa-piggy-bank text-gray-300 text-3xl mb-2"></i>
                                <p class="text-gray-500">No hay donaciones registradas</p>
                            </div>`
                        }
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

    // Funciones auxiliares (se mantienen igual que en el diseño anterior)
    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString(undefined, options);
    }

    function getStatusColorClass(status) {
        const statusLower = status.toLowerCase();
        if (statusLower.includes('aprobado') || statusLower.includes('completado')) {
            return 'bg-green-100 text-green-800';
        } else if (statusLower.includes('pendiente')) {
            return 'bg-yellow-100 text-yellow-800';
        } else if (statusLower.includes('rechazado') || statusLower.includes('cancelado')) {
            return 'bg-red-100 text-red-800';
        }
        return 'bg-gray-100 text-gray-800';
    }

    function closeModal() {
        document.getElementById('viewModal').style.display = 'none';
    }

    // Mantener las funciones existentes de edit y delete
    //function editAdoptante(id) {
        // Implementar edición
       // alert('Función de edición en desarrollo');
   // }

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

        // Cerrar modal al hacer clic fuera
        //document.getElementById('viewModal').addEventListener('click', function(e) {
        //    if (e.target === this) {
        //        closeModal();
        //    }
        //});
    </script>
</body>

</html>
