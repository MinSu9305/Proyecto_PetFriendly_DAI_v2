@extends('layouts.admin')

@section('content')
<div class="p-8 max-w-6xl mx-auto">
    <!-- Header mejorado -->
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('admin.adoption-requests.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-700 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            <span>Volver</span>
        </a>
    </div>
   

    <!-- Tarjeta principal con mejor diseño -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Encabezado de la tarjeta -->
        <div class="bg-pet-yellow px-6 py-4 border-b border-amber-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-900">Detalle de Solicitud de Adopción</h2>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $adoptionRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $adoptionRequest->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $adoptionRequest->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ $adoptionRequest->status_in_spanish }}
                </span>
            </div>
        </div>

        <!-- Contenido de la tarjeta -->
        <div class="p-6">
            <!-- Sección de información en dos columnas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Información del adoptante -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Información del Adoptante</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nombre completo</label>
                            <p class="text-gray-900 font-medium">{{ $adoptionRequest->user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Correo electrónico</label>
                            <p class="text-gray-900 font-medium">{{ $adoptionRequest->user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">DNI</label>
                            <p class="text-gray-900 font-medium">12547896</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Teléfono</label>
                            <p class="text-gray-900 font-medium">123456789</p>
                        </div>
                    </div>
                </div>

                <!-- Información de la mascota -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Información de la Mascota</h3>
                    
                    <div class="flex items-start space-x-4">
                        @if($adoptionRequest->pet->images && count($adoptionRequest->pet->images) > 0)
                        <img src="{{ Storage::url($adoptionRequest->pet->images[0]) }}" 
                             alt="{{ $adoptionRequest->pet->name }}"
                             class="w-20 h-20 object-cover rounded-lg">
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nombre</label>
                            <p class="text-gray-900 font-medium">{{ $adoptionRequest->pet->name }}</p>
                            
                            <div class="grid grid-cols-2 gap-2 mt-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Especie</label>
                                    <p class="text-sm">{{ $adoptionRequest->pet->raza->especie->nombre ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Edad</label>
                                    <p class="text-sm">{{ $adoptionRequest->pet->age }} años</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Motivo de adopción -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3">Motivo de la Adopción</h3>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <p class="text-gray-800 whitespace-pre-line">{{ $adoptionRequest->message }}</p>
                </div>
            </div>

            <!-- Notas del administrador -->
            @if($adoptionRequest->admin_notes)
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3">Notas del Administrador</h3>
                <div class="bg-amber-50 p-4 rounded-lg border border-amber-200">
                    <p class="text-gray-800 whitespace-pre-line">{{ $adoptionRequest->admin_notes }}</p>
                </div>
            </div>
            @endif

            <!-- Acciones -->
            <div class="border-t border-gray-200 pt-6">
                @if($adoptionRequest->status === 'pending')
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <form action="{{ route('admin.adoption-requests.process', $adoptionRequest) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="approved">
                        <button type="button" onclick="confirmApprove(this.form)" 
                                class="w-full sm:w-auto px-6 py-2 bg-lime-500 hover:bg-lime-700 text-white font-semibold rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-check-circle mr-2"></i> Aprobar Solicitud
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.adoption-requests.process', $adoptionRequest) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="rejected">
                        <button type="button" onclick="confirmReject(this.form)" 
                                class="w-full sm:w-auto px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-times-circle mr-2"></i> Rechazar Solicitud
                        </button>
                    </form>
                </div>
                @else
                <div class="flex justify-center">
                    <a href="{{ route('admin.adoption-requests.edit', $adoptionRequest) }}" 
                       class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg transition-colors flex items-center">
                        <i class="fas fa-edit mr-2"></i> Editar Solicitud
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modales (se mantienen igual) -->
<div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 overflow-hidden">
        <div class="bg-lime-500 px-4 py-3 flex justify-between items-center">
            <h3 class="font-bold text-black">Confirmar Aprobación</h3>
            <button onclick="closeModal('approveModal')" class="text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-lime-100 mb-4">
                <i class="fas fa-check text-black"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">¿Aprobar esta solicitud?</h3>
            <p class="text-sm text-gray-500 mb-6">La solicitud será marcada como aprobada y se notificará al adoptante.</p>
            <div class="flex justify-center space-x-4">
                <button onclick="closeModal('approveModal')" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg">
                    Cancelar
                </button>
                <button id="approveConfirmBtn" class="px-6 py-2 bg-lime-500 text-black font-semibold rounded-lg">
                    Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 overflow-hidden">
        <div class="bg-red-600 px-4 py-3 flex justify-between items-center">
            <h3 class="font-bold text-white">Confirmar Rechazo</h3>
            <button onclick="closeModal('rejectModal')" class="text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-times text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">¿Rechazar esta solicitud?</h3>
            <p class="text-sm text-gray-500 mb-6">La solicitud será marcada como rechazada y se notificará al adoptante.</p>
            <div class="flex justify-center space-x-4">
                <button onclick="closeModal('rejectModal')" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg">
                    Cancelar
                </button>
                <button id="rejectConfirmBtn" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg">
                    Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // El script JavaScript se mantiene igual
    let approveForm = null;
    let rejectForm = null;

    function confirmApprove(form) {
        approveForm = form;
        const modal = document.getElementById('approveModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function confirmReject(form) {
        rejectForm = form;
        const modal = document.getElementById('rejectModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('approveConfirmBtn').addEventListener('click', function() {
        if (approveForm) {
            approveForm.submit();
        }
    });

    document.getElementById('rejectConfirmBtn').addEventListener('click', function() {
        if (rejectForm) {
            rejectForm.submit();
        }
    });
</script>
@endsection