@extends('layouts.admin')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="flex items-center mb-8">
        <a href="{{ route('admin.adoption-requests.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Solicitudes de</h1>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Información del adoptante -->
            <div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" value="{{ $adoptionRequest->user->name }}" readonly
                               class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                        <input type="text" value="{{ $adoptionRequest->user->name }}" readonly
                               class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">DNI</label>
                        <input type="text" value="12547896" readonly
                               class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Celular</label>
                        <input type="text" value="123456789" readonly
                               class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    </div>
                </div>
            </div>

            <!-- Información de la mascota -->
            <div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mascota</label>
                    <input type="text" value="{{ $adoptionRequest->pet->name }}" readonly
                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                </div>
            </div>
        </div>

        <!-- Motivo de adopción -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Motivo de la Adopción</label>
            <textarea readonly rows="4" 
                      class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">{{ $adoptionRequest->message }}</textarea>
        </div>

        <!-- Notas del administrador (si existen) -->
        @if($adoptionRequest->admin_notes)
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Notas del Administrador</label>
            <textarea readonly rows="3" 
                      class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">{{ $adoptionRequest->admin_notes }}</textarea>
        </div>
        @endif

        <!-- Estado actual -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Estado actual</label>
            <div class="px-3 py-2">
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $adoptionRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $adoptionRequest->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $adoptionRequest->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ $adoptionRequest->status_in_spanish }}
                </span>
            </div>
        </div>

        <!-- Acciones -->
        @if($adoptionRequest->status === 'pending')
        <div class="flex justify-center space-x-4 pt-4">
            <form action="{{ route('admin.adoption-requests.process', $adoptionRequest) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="approved">
                <button type="button" onclick="confirmApprove(this.form)" 
                        class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                    Aprobar
                </button>
            </form>
            
            <form action="{{ route('admin.adoption-requests.process', $adoptionRequest) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="rejected">
                <button type="button" onclick="confirmReject(this.form)" 
                        class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                    Rechazar
                </button>
            </form>
        </div>
        @else
        <div class="flex justify-center pt-4">
            <a href="{{ route('admin.adoption-requests.edit', $adoptionRequest) }}" 
               class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                Editar solicitud
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Modal de confirmación para aprobar -->
<div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white rounded-t-xl rounded-b-xl max-w-md w-full mx-4 overflow-hidden">
        <div class="bg-pet-yellow px-4 py-3 flex justify-between items-center">
            <h3 class="font-bold">Confirmar Proceso</h3>
            <button onclick="closeModal('approveModal')" class="text-black">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6 text-center">
            <p class="text-xl font-bold mb-6">¿Desea aprobar solicitud de adopción?</p>
            <div class="flex justify-center space-x-4">
                <button id="approveConfirmBtn" class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                    Aceptar
                </button>
                <button onclick="closeModal('approveModal')" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para rechazar -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white rounded-t-xl rounded-b-xl max-w-md w-full mx-4 overflow-hidden">
        <div class="bg-pet-yellow px-4 py-3 flex justify-between items-center">
            <h3 class="font-bold">Confirmar Proceso</h3>
            <button onclick="closeModal('rejectModal')" class="text-black">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6 text-center">
            <p class="text-xl font-bold mb-6">¿Desea rechazar solicitud de adopción?</p>
            <div class="flex justify-center space-x-4">
                <button id="rejectConfirmBtn" class="px-6 py-2 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                    Aceptar
                </button>
                <button onclick="closeModal('rejectModal')" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
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
