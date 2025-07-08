@extends('layouts.user')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        
        <!-- Formulario de Donación -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="flex flex-col lg:flex-row">
                <!-- Columna Izquierda - Información de la Donación -->
                <div class="w-full lg:w-1/2 bg-pet-yellow p-8 flex flex-col justify-center">
                    <div class="text-center mb-8">
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">
                            Ayuda a más mascotas<br>
                            con tu <span class="text-white">DONACIÓN</span>
                        </h1>
                        <p class="text-lg text-gray-700">Tu aporte hace la diferencia en la vida de nuestras mascotas</p>
                    </div>

                    <!-- Datos Bancarios Destacados -->
                    <div class="bg-white bg-opacity-90 rounded-xl p-6 shadow-sm">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Datos Bancarios:</h3>
                        <div class="space-y-3 text-gray-700">
                            <div class="flex items-start">
                                <i class="fas fa-university text-gray-500 mt-1 mr-3"></i>
                                <p><span class="font-semibold">Banco:</span> BCP</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-home text-gray-500 mt-1 mr-3"></i>
                                <p><span class="font-semibold">Refugio:</span> PetFriendly</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-wallet text-gray-500 mt-1 mr-3"></i>
                                <p><span class="font-semibold">Cuenta:</span> 193-2222486-0-52</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-exchange-alt text-gray-500 mt-1 mr-3"></i>
                                <p><span class="font-semibold">Interbancario:</span> 002-193002222486052-12</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha - Formulario -->
                <div class="w-full lg:w-1/2 p-8">
                    <form id="donation-form" action="{{ route('user.donations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Monto -->
                        <div>
                            <label for="amount" class="block text-lg font-semibold text-gray-700 mb-3">Monto:</label>
                            <div class="relative">
                                <select id="amount" name="amount" required
                                        class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-pet-yellow focus:border-pet-yellow appearance-none bg-white">
                                    <option value="">00.00</option>
                                    <option value="10">S/. 10.00</option>
                                    <option value="25">S/. 25.00</option>
                                    <option value="50">S/. 50.00</option>
                                    <option value="100">S/. 100.00</option>
                                    <option value="200">S/. 200.00</option>
                                    <option value="500">S/. 500.00</option>
                                    <option value="custom">Otro monto</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                            
                            <!-- Campo personalizado para "otro monto" -->
                            <div id="custom-amount" class="mt-3 hidden">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">S/.</span>
                                    </div>
                                    <input type="number" id="custom_amount_input" min="1" step="0.01" placeholder="0.00"
                                           class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pet-yellow focus:border-pet-yellow">
                                </div>
                            </div>
                            
                            @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Nombres y Apellidos (Solo lectura) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-lg font-semibold text-gray-700 mb-3">Nombres</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" value="{{ Auth::user()->first_name }}" 
                                           readonly
                                           class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed">
                                </div>
                            </div>
                            <div>
                                <label class="block text-lg font-semibold text-gray-700 mb-3">Apellidos</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" value="{{ Auth::user()->last_name }}" 
                                           readonly
                                           class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed">
                                </div>
                            </div>
                        </div>

                        <!-- Subir Comprobante -->
                        <div>
                            <label class="block text-lg font-semibold text-gray-700 mb-3">Subir comprobante</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-pet-yellow transition-colors">
                                <input type="file" id="receipt" name="receipt" accept="image/*,.pdf" class="hidden" onchange="showFileName(event)">
                                <label for="receipt" class="cursor-pointer">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                        <p class="text-sm text-gray-500 mt-1">PNG, JPG, PDF hasta 5MB</p>
                                    </div>
                                </label>
                                <div id="file-name" class="mt-3 text-sm text-green-600 hidden"></div>
                            </div>
                            @error('receipt') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Comentario -->
                        <div>
                            <label for="message" class="block text-lg font-semibold text-gray-700 mb-3">Comentario:</label>
                            <textarea id="message" name="message" rows="1" placeholder="Escribir un mensaje opcional..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pet-yellow focus:border-pet-yellow resize-none"></textarea>
                            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Botón Donar -->
                        <div class="pt-4">
                            <button type="button" onclick="confirmDonation()" 
                                    class="w-full py-4 bg-pet-yellow hover:bg-pet-yellow-dark text-black text-xl font-bold rounded-lg shadow-md transition-colors">
                                <i class="fas fa-heart mr-2"></i> Donar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Manejar selección de monto personalizado
    document.getElementById('amount').addEventListener('change', function() {
        const customAmountDiv = document.getElementById('custom-amount');
        const customAmountInput = document.getElementById('custom_amount_input');
        
        if (this.value === 'custom') {
            customAmountDiv.classList.remove('hidden');
            customAmountInput.required = true;
        } else {
            customAmountDiv.classList.add('hidden');
            customAmountInput.required = false;
            customAmountInput.value = '';
        }
    });

    // Mostrar nombre del archivo seleccionado
    function showFileName(event) {
        const file = event.target.files[0];
        const fileNameDiv = document.getElementById('file-name');
        
        if (file) {
            fileNameDiv.textContent = `Archivo seleccionado: ${file.name}`;
            fileNameDiv.classList.remove('hidden');
        }
    }

    // Confirmar donación
    function confirmDonation() {
        const form = document.getElementById('donation-form');
        const amountSelect = document.getElementById('amount');
        const customAmountInput = document.getElementById('custom_amount_input');
        
        // Validar formulario
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Obtener el monto final
        let finalAmount;
        if (amountSelect.value === 'custom') {
            finalAmount = customAmountInput.value;
            // Actualizar el campo amount con el valor personalizado
            amountSelect.innerHTML += `<option value="${finalAmount}" selected>S/. ${finalAmount}</option>`;
        } else {
            finalAmount = amountSelect.value;
        }
        
        // Mostrar modal de confirmación
        const actions = `
            <button onclick="document.getElementById('donation-form').submit()" 
                    class="px-6 py-3 bg-pet-yellow hover:bg-pet-yellow-dark text-black font-semibold rounded-lg">
                Confirmar Donación
            </button>
            <button onclick="closeModal()" 
                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg">
                Cancelar
            </button>
        `;
        
        showModal('Confirmar Donación', `¿Confirmar donación de S/. ${finalAmount}?`, actions);
    }
</script>
@endsection