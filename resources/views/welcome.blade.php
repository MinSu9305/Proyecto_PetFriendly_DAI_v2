<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pet Friendly - Refugio de Mascotas</title>
    <link rel="icon" href="/images/LogoPag.png" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS CDN para pruebas rápidas -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Configuración personalizada de colores */
        .bg-pet-yellow {
            background-color: #FCD34D;
        }

        .hover\:bg-pet-yellow:hover {
            background-color: #F59E0B;
        }

        .text-pet-yellow {
            color: #f3b447;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <img src="/images/sloganphoto.png" alt="Logo Pet Friendly" class="w-10 h-10 object-contain">
                    <span class="text-xl font-bold text-gray-900">Pet Friendly</span>
                </div>


                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-700 hover:text-gray-900">Inicio</a>
                    <a href="#que-debo-saber" class="text-gray-700 hover:text-gray-900">¿Qué debo saber?</a>
                    <a href="#mascotas" class="text-gray-700 hover:text-gray-900">Nuestras mascotas adoptadas</a>
                </nav>

                <!-- Auth Button -->
                <button onclick="showAuthModal('login')" class="bg-pet-yellow hover:bg-pet-yellow text-black font-semibold px-6 py-2 rounded-full transition duration-200">
                    Acceder
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br bg-white to-orange-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="text-pet-yellow font-semibold text-lg mb-4">Pet Lovers</p>
                    <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                        Adopta un <span class="text-pet-yellow">AMIGO</span><br>
                        para <span class="text-pet-yellow">SIEMPRE</span>
                    </h1>
                    <p class="text-gray-600 text-lg mb-8">
                        Encuentra a tu compañero ideal y bríndales un hogar lleno de amor. ¡Adoptar es salvar una vida!
                    </p>
                </div>
                <div class="relative">
                    <img src="/images/dogcatportada.png" alt="Perro y Gato"
                        class="w-full max-w-md mx-auto mb-4 object-contain">
                </div>
            </div>
        </div>
    </section>


    <!-- ¿Qué debo saber? Section -->
    <section id="que-debo-saber" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">¿QUÉ DEBO SABER?</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Proceso -->
                <div>
                    <!-- Título arriba del cuadro -->
                    <div class="text-center mb-4">
                        <div
                            class="bg-pet-yellow text-black font-bold py-2 px-4 rounded-full text-center mb-6 border border-black">
                            PROCESO
                        </div>
                    </div>

                    <!-- Cuadro gris con los pasos -->
                    <div class="bg-white border border-black rounded-2xl p-6">
                        <ol class="space-y-3 text-gray-700">
                            <li>1. Elige tu compañero</li>
                            <li>2. Explora nuestras mascotas disponibles y selecciónalo.</li>
                            <li>3. Completa el formulario</li>
                            <li>4. Bienvenido a casa PetFriendly.</li>
                        </ol>
                    </div>
                </div>

                <!-- RESPONSABILIDAD -->
                <div>
                    <div class="text-center mb-4">
                        <div
                            class="bg-pet-yellow text-black font-bold py-2 px-4 rounded-full text-center mb-6 border border-black">
                            RESPONSABILIDAD
                        </div>
                    </div>
                    <div class="bg-white border border-black rounded-2xl p-6">
                        <p class="text-gray-700">
                            Adoptar un PetFriendly es un compromiso de amor y responsabilidad. Significa cuidarlo,
                            alimentarlo, respetarlo y llenarlo de cariño todos los días. Antes de dar este gran paso,
                            asegúrate de estar listo para brindarle todo lo que necesita para ser feliz.
                        </p>
                    </div>
                </div>

                <!-- PREPARA EL ESPACIO -->
                <div>
                    <div class="text-center mb-4">
                        <div
                            class="bg-pet-yellow text-black font-bold py-2 px-4 rounded-full text-center mb-6 border border-black">
                            PREPARA EL ESPACIO
                        </div>
                    </div>
                    <div class="bg-white border border-black rounded-2xl p-6">
                        <p class="text-gray-700">
                            Antes de adoptar una mascota, es importante preparar tu hogar para garantizar su bienestar.
                            Asegúrate de contar con un espacio seguro y cómodo, con camas, comederos y juguetes
                            adecuados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mascotas Adoptadas Section -->
    <section id="mascotas" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">NUESTRAS MASCOTAS ADOPTADAS</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                <!-- Mascota 1 -->
                <div class="text-center">
                    <div>
                        <img src="/images/gatito1.png" alt="" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <p class="font-semibold text-2xl text-gray-900 mt-2">Milo</p>
                </div>

                <!-- Mascota 2 -->
                <div class="text-center">
                    <div>
                        <img src="/images/perro3.png" alt="" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <p class="font-semibold text-2xl text-gray-900 mt-2">Max</p>
                </div>

                <!-- Mascota 3 -->
                <div class="text-center">
                    <div>
                        <img src="/images/gato2.png" alt="" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <p class="font-semibold text-2xl text-gray-900 mt-2">Luna</p>
                </div>

                <!-- Mascota 4 -->
                <div class="text-center">
                    <div>
                        <img src="/images/mascota4.png" alt="" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <p class="font-semibold text-2xl text-gray-900 mt-2">Lucas</p>
                </div>
                <!-- Mascota 5 -->
                <div class="text-center">
                    <div>
                        <img src="/images/perrito1.png" alt="" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <p class="font-semibold text-2xl text-gray-900 mt-2">Rocky</p>
                </div>

                <!-- Mascota 6 -->
                <div class="text-center">
                    <div>
                        <img src="/images/perrito2.png" alt="" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <p class="font-semibold text-2xl text-gray-900 mt-2">Toby</p>
                </div>

                <!-- Mascota 7 -->
                <div class="text-center">
                    <div>
                        <img src="/images/perrito3.png" alt="" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <p class="font-semibold text-2xl text-gray-900 mt-2">Coco</p>
                </div>

                <!-- Mascota 8 -->
                <div class="text-center">
                    <div>
                        <img src="/images/perro4.png" alt="" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <p class="font-semibold text-2xl text-gray-900 mt-2">Duke</p>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="showAuthModal('login')" class="bg-pet-yellow hover:bg-pet-yellow text-black font-bold py-3 px-8 rounded-full transition duration-200">
                    ¡Quiero adoptar!
                </button>
                <button onclick="showAuthModal('login')" class="bg-pet-yellow hover:bg-pet-yellow text-black font-bold py-3 px-8 rounded-full transition duration-200">
                    ¡Quiero ayudar! (Donar)
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Logo y descripción -->
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <img src="/images/sloganphoto.png" alt="Logo Pet Friendly" class="w-10 h-10 object-contain">
                        <span class="text-lg font-bold">Pet Friendly</span>
                    </div>
                    <p class="text-gray-600 mb-4">
                        PetFriendly es una organización que busca brindar un hogar a mascotas. ¡Adopta y cambia una
                        vida!
                    </p>
                    <!-- Social Media -->
                    <div class="flex space-x-3">
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/profile.php?id=61576931204543" target="_blank"
                            class="w-10 h-10 bg-pet-yellow rounded-full flex items-center justify-center hover:scale-110 transition">
                            <i class="fa-brands fa-facebook-f text-black"></i>
                        </a>

                        <!-- Instagram -->
                        <a href="https://www.instagram.com/petfriendly_rm/" target="_blank"
                            class="w-10 h-10 bg-pet-yellow rounded-full flex items-center justify-center hover:scale-110 transition">
                            <i class="fa-brands fa-instagram text-black"></i>
                        </a>

                        <!-- YouTube -->
                        <a href="https://www.youtube.com/@petfriendly_rm" target="_blank"
                            class="w-10 h-10 bg-pet-yellow rounded-full flex items-center justify-center hover:scale-110 transition">
                            <i class="fa-brands fa-youtube text-black"></i>
                        </a>
                    </div>

                </div>

                <!-- Links -->
                <div>
                    <ul class="space-y-2 text-gray-600 text-center">
                        <li><a href="#" class="hover:text-gray-900">Inicio</a></li>
                        <li><a href="#" class="hover:text-gray-900">¿Qué debo saber?</a></li>
                        <li><a href="#" class="hover:text-gray-900">Nuestras mascotas adoptadas</a></li>
                    </ul>

                </div>

                <!-- Contacto -->
                <div>
                    <div class="space-y-2 text-gray-600">
                        <p class="flex items-center gap-2">
                            <i class="fa-solid fa-location-dot" style="color: #FFD43B;"></i>
                            Avenida 001, Miraflores.
                        </p>
                        <p class="ml-6">Lima - Perú</p>

                        <p class="flex items-center gap-2">
                            <i class="fa-solid fa-phone" style="color: #FFD43B;"></i>
                            +51 934 464 041
                        </p>

                        <p class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope" style="color: #FFD43B;"></i>
                            petfriendly@gmail.com
                        </p>
                    </div>

                </div>
            </div>

            <div class="border-t border-gray-200 mt-8 pt-8 text-center text-gray-500">
                <p>© Copyright PetFriendly 2025. Lima - Perú</p>
            </div>
        </div>
    </footer>

    











    <!-- Auth Modal -->
    <div id="authModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-pet-yellow px-6 py-4">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <span class="text-lg font-bold text-black">PetFriendly</span>
                    </div>

                    <!-- Tab Buttons -->
                    <div class="flex space-x-2">
                        <button id="loginTab" onclick="switchTab('login')" class="px-4 py-2 rounded-full text-sm font-semibold transition-colors duration-200">
                            Iniciar sesión
                        </button>
                        <button id="registerTab" onclick="switchTab('register')" class="px-4 py-2 rounded-full text-sm font-semibold transition-colors duration-200">
                            Registrarse
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="p-8">
                <!-- Login Form -->
                <div id="loginForm" class="auth-form">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">INICIAR SESIÓN</h2>
                    </div>

                    <form id="loginFormSubmit" class="space-y-4">
                        <div>
                            <input type="email" id="loginEmail" placeholder="Correo:" required
                                   class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            <div id="loginEmailError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                        
                        <div>
                            <input type="password" id="loginPassword" placeholder="Contraseña:" required
                                   class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            <div id="loginPasswordError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <button type="submit" class="w-full bg-pet-yellow hover:bg-pet-yellow-dark text-black font-bold py-3 rounded-lg transition duration-200">
                            INICIAR
                        </button>
                    </form>
                </div>

                <!-- Register Form -->
                <div id="registerForm" class="auth-form hidden">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">REGISTRARSE</h2>
                    </div>

                    <form id="registerFormSubmit" class="space-y-4">
                        <div>
                            <input type="text" id="registerName" placeholder="Nombre:" required
                                   class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            <div id="registerNameError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div>
                            <input type="email" id="registerEmail" placeholder="Correo:" required
                                   class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            <div id="registerEmailError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div class="relative">
                            <input type="date" id="registerBirthDate" placeholder="Fecha de Nacimiento:" required
                                   class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            <div id="registerBirthDateError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div>
                            <input type="password" id="registerPassword" placeholder="Contraseña:" required
                                   class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            <div id="registerPasswordError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div>
                            <input type="password" id="registerPasswordConfirm" placeholder="Confirmar contraseña:" required
                                   class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                            <div id="registerPasswordConfirmError" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <button type="submit" class="w-full bg-pet-yellow hover:bg-pet-yellow-dark text-black font-bold py-3 rounded-lg transition duration-200">
                            REGISTRARSE
                        </button>
                    </form>
                </div>

                <!-- Back Button -->
                <div class="text-center mt-6">
                    <button onclick="hideAuthModal()" class="text-gray-600 hover:text-gray-900 flex items-center justify-center mx-auto">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Volver
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <div id="messageContainer" class="fixed top-4 right-4 z-50 hidden">
        <div id="messageContent" class="px-6 py-3 rounded-lg text-white font-semibold"></div>
    </div>

    <script>
        let currentTab = 'login';

        function showAuthModal(tab = 'login') {
            const modal = document.getElementById('authModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            switchTab(tab);
        }

        function hideAuthModal() {
            const modal = document.getElementById('authModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            clearErrors();
        }

        function switchTab(tab) {
            currentTab = tab;
            
            // Hide all forms
            document.querySelectorAll('.auth-form').forEach(form => {
                form.classList.add('hidden');
            });
            
            // Show selected form
            document.getElementById(tab + 'Form').classList.remove('hidden');
            
            // Update tab buttons
            const loginTab = document.getElementById('loginTab');
            const registerTab = document.getElementById('registerTab');
            
            if (tab === 'login') {
                loginTab.classList.add('bg-black', 'text-white');
                loginTab.classList.remove('bg-transparent', 'text-black');
                registerTab.classList.add('bg-transparent', 'text-black');
                registerTab.classList.remove('bg-black', 'text-white');
            } else {
                registerTab.classList.add('bg-black', 'text-white');
                registerTab.classList.remove('bg-transparent', 'text-black');
                loginTab.classList.add('bg-transparent', 'text-black');
                loginTab.classList.remove('bg-black', 'text-white');
            }
            
            clearErrors();
        }

        function clearErrors() {
            document.querySelectorAll('[id$="Error"]').forEach(error => {
                error.classList.add('hidden');
                error.textContent = '';
            });
        }

        function showMessage(message, type = 'success') {
            const container = document.getElementById('messageContainer');
            const content = document.getElementById('messageContent');
            
            content.textContent = message;
            content.className = `px-6 py-3 rounded-lg text-white font-semibold ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            
            container.classList.remove('hidden');
            
            setTimeout(() => {
                container.classList.add('hidden');
            }, 5000);
        }

        function validateAge(birthDate) {
            const today = new Date();
            const birth = new Date(birthDate);
            const age = today.getFullYear() - birth.getFullYear();
            const monthDiff = today.getMonth() - birth.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
                age--;
            }
            
            return age >= 20;
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Login Form Handler
        document.getElementById('loginFormSubmit').addEventListener('submit', function(e) {
            e.preventDefault();
            clearErrors();
            
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            
            let hasErrors = false;
            
            // Validate email
            if (!email) {
                document.getElementById('loginEmailError').textContent = 'El correo es requerido';
                document.getElementById('loginEmailError').classList.remove('hidden');
                hasErrors = true;
            } else if (!validateEmail(email)) {
                document.getElementById('loginEmailError').textContent = 'Ingresa un correo válido';
                document.getElementById('loginEmailError').classList.remove('hidden');
                hasErrors = true;
            }
            
            // Validate password
            if (!password) {
                document.getElementById('loginPasswordError').textContent = 'La contraseña es requerida';
                document.getElementById('loginPasswordError').classList.remove('hidden');
                hasErrors = true;
            } else if (password.length < 6) {
                document.getElementById('loginPasswordError').textContent = 'La contraseña debe tener al menos 6 caracteres';
                document.getElementById('loginPasswordError').classList.remove('hidden');
                hasErrors = true;
            }
            
            if (!hasErrors) {
                // Aquí iría la lógica de autenticación con Laravel
                showMessage('Inicio de sesión exitoso');
                hideAuthModal();
                // Redirect or update UI
            }
        });

        // Register Form Handler
        document.getElementById('registerFormSubmit').addEventListener('submit', function(e) {
            e.preventDefault();
            clearErrors();
            
            const name = document.getElementById('registerName').value;
            const email = document.getElementById('registerEmail').value;
            const birthDate = document.getElementById('registerBirthDate').value;
            const password = document.getElementById('registerPassword').value;
            const passwordConfirm = document.getElementById('registerPasswordConfirm').value;
            
            let hasErrors = false;
            
            // Validate name
            if (!name) {
                document.getElementById('registerNameError').textContent = 'El nombre es requerido';
                document.getElementById('registerNameError').classList.remove('hidden');
                hasErrors = true;
            } else if (name.length < 2) {
                document.getElementById('registerNameError').textContent = 'El nombre debe tener al menos 2 caracteres';
                document.getElementById('registerNameError').classList.remove('hidden');
                hasErrors = true;
            }
            
            // Validate email
            if (!email) {
                document.getElementById('registerEmailError').textContent = 'El correo es requerido';
                document.getElementById('registerEmailError').classList.remove('hidden');
                hasErrors = true;
            } else if (!validateEmail(email)) {
                document.getElementById('registerEmailError').textContent = 'Ingresa un correo válido';
                document.getElementById('registerEmailError').classList.remove('hidden');
                hasErrors = true;
            }
            
            // Validate birth date and age
            if (!birthDate) {
                document.getElementById('registerBirthDateError').textContent = 'La fecha de nacimiento es requerida';
                document.getElementById('registerBirthDateError').classList.remove('hidden');
                hasErrors = true;
            } else if (!validateAge(birthDate)) {
                document.getElementById('registerBirthDateError').textContent = 'Debes ser mayor de 20 años para registrarte';
                document.getElementById('registerBirthDateError').classList.remove('hidden');
                hasErrors = true;
            }
            
            // Validate password
            if (!password) {
                document.getElementById('registerPasswordError').textContent = 'La contraseña es requerida';
                document.getElementById('registerPasswordError').classList.remove('hidden');
                hasErrors = true;
            } else if (password.length < 6) {
                document.getElementById('registerPasswordError').textContent = 'La contraseña debe tener al menos 6 caracteres';
                document.getElementById('registerPasswordError').classList.remove('hidden');
                hasErrors = true;
            }
            
            // Validate password confirmation
            if (!passwordConfirm) {
                document.getElementById('registerPasswordConfirmError').textContent = 'Confirma tu contraseña';
                document.getElementById('registerPasswordConfirmError').classList.remove('hidden');
                hasErrors = true;
            } else if (password !== passwordConfirm) {
                document.getElementById('registerPasswordConfirmError').textContent = 'Las contraseñas no coinciden';
                document.getElementById('registerPasswordConfirmError').classList.remove('hidden');
                hasErrors = true;
            }
            
            if (!hasErrors) {
                // Aquí iría la lógica de registro con Laravel
                showMessage('Registro exitoso');
                hideAuthModal();
                // Redirect or update UI
            }
        });

        // Close modal when clicking outside
        document.getElementById('authModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideAuthModal();
            }
        });

        // Initialize tab styles
        switchTab('login');
    </script>
</body>
</html>

