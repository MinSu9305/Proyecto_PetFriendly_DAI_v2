<div class="p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Listar Mascotas</h1>
        <button wire:click="openCreateModal" class="bg-pet-yellow hover:bg-pet-yellow-dark text-black font-bold px-6 py-3 rounded-lg flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Agregar nueva mascota</span>
        </button>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <div class="relative">
            <input type="text" wire:model.live="search" placeholder="Buscar..." 
                   class="w-full max-w-md px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-pet-yellow">
                <tr>
                    <th class="px-6 py-4 text-left text-black font-bold">Nombre</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Edad</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Especie</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Raza</th>
                    <th class="px-6 py-4 text-left text-black font-bold">Sexo</th>
                    <th class="px-6 py-4 text-center text-black font-bold">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($pets as $pet)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $pet->name }}</td>
                    <td class="px-6 py-4 text-gray-900">{{ $pet->age }} {{ $pet->age == 1 ? 'año' : 'años' }}</td>
                    <td class="px-6 py-4 text-gray-900">{{ $pet->type_in_spanish }}</td>
                    <td class="px-6 py-4 text-gray-900">{{ $pet->breed }}</td>
                    <td class="px-6 py-4 text-gray-900">{{ $pet->gender_in_spanish }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2">
                            <button wire:click="openViewModal({{ $pet->id }})" 
                                    class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button wire:click="openEditModal({{ $pet->id }})" 
                                    class="p-2 text-green-600 hover:bg-green-100 rounded-lg" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        No se encontraron mascotas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($pets->hasPages())
    <div class="mt-6">
        {{ $pets->links() }}
    </div>
    @endif

    <!-- Create/Edit Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeModal">
        <div class="bg-white rounded-lg max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" wire:click.stop>
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold">
                        {{ $modalMode === 'create' ? 'Agregar Mascota' : 'Editar Mascota' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Content -->
            <form wire:submit="save" class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" wire:model="name" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Edad -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Edad</label>
                        <input type="number" wire:model="age" min="0" max="20"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        @error('age') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Especie -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Especie</label>
                        <select wire:model="type" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            <option value="">Seleccionar...</option>
                            <option value="dog">Perro</option>
                            <option value="cat">Gato</option>
                            <option value="other">Otro</option>
                        </select>
                        @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Sexo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sexo</label>
                        <select wire:model="gender" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            <option value="">Seleccionar...</option>
                            <option value="male">Macho</option>
                            <option value="female">Hembra</option>
                        </select>
                        @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Raza -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Raza</label>
                        <input type="text" wire:model="breed" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        @error('breed') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tamaño -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tamaño</label>
                        <select wire:model="size" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            <option value="">Seleccionar...</option>
                            <option value="small">Pequeño</option>
                            <option value="medium">Mediano</option>
                            <option value="large">Grande</option>
                        </select>
                        @error('size') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    @if($modalMode === 'edit')
                    <!-- Estado (solo en edición) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select wire:model="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            <option value="available">Disponible</option>
                            <option value="pending">Pendiente</option>
                            <option value="adopted">Adoptado</option>
                        </select>
                        @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    @endif
                </div>

                <!-- Subir Foto -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subir Foto</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                        <input type="file" wire:model="photo" accept="image/*" class="hidden" id="photo-upload">
                        <label for="photo-upload" class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-600">Haz clic para subir una imagen</p>
                            <p class="text-sm text-gray-500">PNG, JPG hasta 2MB</p>
                        </label>
                        
                        @if ($photo)
                            <div class="mt-4">
                                <img src="{{ $photo->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-lg mx-auto">
                            </div>
                        @elseif ($currentPhoto)
                            <div class="mt-4">
                                <img src="{{ Storage::url($currentPhoto) }}" class="w-32 h-32 object-cover rounded-lg mx-auto">
                            </div>
                        @endif
                    </div>
                    @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Descripción -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea wire:model="description" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Checkboxes -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <input type="checkbox" wire:model="is_vaccinated" id="vaccinated" class="mr-2">
                        <label for="vaccinated" class="text-sm text-gray-700">Vacunado</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" wire:model="is_sterilized" id="sterilized" class="mr-2">
                        <label for="sterilized" class="text-sm text-gray-700">Esterilizado</label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" wire:click="closeModal" 
                            class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- View Modal -->
    @if($showViewModal && $selectedPet)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeModal">
        <div class="bg-white rounded-lg max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" wire:click.stop>
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold">Detalles de {{ $selectedPet->name }}</h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Información -->
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900">Información Básica</h4>
                            <p><strong>Nombre:</strong> {{ $selectedPet->name }}</p>
                            <p><strong>Edad:</strong> {{ $selectedPet->age }} {{ $selectedPet->age == 1 ? 'año' : 'años' }}</p>
                            <p><strong>Especie:</strong> {{ $selectedPet->type_in_spanish }}</p>
                            <p><strong>Raza:</strong> {{ $selectedPet->breed }}</p>
                            <p><strong>Sexo:</strong> {{ $selectedPet->gender_in_spanish }}</p>
                            <p><strong>Tamaño:</strong> {{ $selectedPet->size_in_spanish }}</p>
                            <p><strong>Estado:</strong> 
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $selectedPet->status === 'available' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $selectedPet->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $selectedPet->status === 'adopted' ? 'bg-blue-100 text-blue-800' : '' }}">
                                    {{ $selectedPet->status_in_spanish }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900">Estado de Salud</h4>
                            <p><strong>Vacunado:</strong> {{ $selectedPet->is_vaccinated ? 'Sí' : 'No' }}</p>
                            <p><strong>Esterilizado:</strong> {{ $selectedPet->is_sterilized ? 'Sí' : 'No' }}</p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900">Descripción</h4>
                            <p class="text-gray-700">{{ $selectedPet->description }}</p>
                        </div>
                    </div>

                    <!-- Foto -->
                    <div>
                        @if($selectedPet->images && count($selectedPet->images) > 0)
                            <img src="{{ Storage::url($selectedPet->images[0]) }}" 
                                 alt="{{ $selectedPet->name }}" 
                                 class="w-full h-64 object-cover rounded-lg">
                        @else
                            <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                <div class="text-center text-gray-500">
                                    <i class="fas fa-paw text-4xl mb-2"></i>
                                    <p>Sin foto</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg z-50">
            {{ session('message') }}
        </div>
    @endif
</div>
