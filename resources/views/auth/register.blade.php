<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Sistema de Serigrafía</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 font-sans antialiased text-white">

    <div class="min-h-screen flex flex-col lg:flex-row">
        
        <!-- Columna Izquierda: Imagen de fondo y marca (visible en pantallas medianas/grandes) -->
        <div class="hidden lg:flex lg:w-1/2 bg-cover bg-center relative" 
             style="background-image: url('{{ asset('images/fondo.jpg') }}');">
            <!-- Overlay oscuro -->
            <div class="absolute inset-0 bg-slate-950/70 backdrop-blur-xs"></div>
            
            <div class="relative z-10 flex flex-col justify-between p-12 w-full">
                <div>
                    <span class="bg-indigo-600 text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider text-white">
                        Sistema de Gestión
                    </span>
                </div>
                <div class="space-y-4">
                    <img src="{{ asset('images/fondo.png') }}" alt="Logo" width="450">
                    <h2 class="text-4xl font-extrabold tracking-tight text-white">Únete a la Plataforma</h2>
                    <p class="text-slate-300 text-lg max-w-md">Crea usuarios para tu equipo de trabajo y gestiona roles de acceso de forma rápida.</p>
                </div>
                <div class="text-sm text-slate-400">
                    © {{ date('Y') }} — Desarrollado para la gestión de producción.
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Formulario de Registro -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 md:p-12 bg-slate-900">
            <div class="w-full max-w-md space-y-6 bg-slate-800/90 p-8 rounded-2xl border border-slate-700 shadow-2xl backdrop-blur-md">
                
                <!-- Encabezado -->
                <div class="text-center space-y-2">
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 mx-auto mb-2 object-contain">
                    @endif
                    <h2 class="text-2xl font-bold tracking-tight text-white">Crear nueva cuenta</h2>
                    <p class="text-xs text-slate-400">Ingresa tus datos para registrarte en el sistema</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Nombre completo -->
                    <div>
                        <label for="name" class="block text-slate-300 font-medium text-sm mb-1">Nombre Completo</label>
                        <input id="name" 
                               class="block w-full bg-slate-900 border border-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm shadow-inner placeholder-slate-500" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus 
                               autocomplete="name" 
                               placeholder="Juan Pérez" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Correo Electrónico -->
                    <div>
                        <label for="email" class="block text-slate-300 font-medium text-sm mb-1">Correo Electrónico</label>
                        <input id="email" 
                               class="block w-full bg-slate-900 border border-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl px-4 py-3 text-sm shadow-inner placeholder-slate-500" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="username" 
                               placeholder="usuario@ejemplo.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-slate-300 font-medium text-sm mb-1">Contraseña</label>
                        <div class="relative">
                            <input id="password" 
                                   class="block w-full bg-slate-900 border border-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl px-4 py-3 pr-12 text-sm shadow-inner placeholder-slate-500"
                                   type="password"
                                   name="password"
                                   required 
                                   autocomplete="new-password" 
                                   placeholder="••••••••" />
                            
                            <button type="button" 
                                    onclick="togglePassword('password', 'eye-icon-1')" 
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-white transition-colors focus:outline-none">
                                <svg id="eye-icon-1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div>
                        <label for="password_confirmation" class="block text-slate-300 font-medium text-sm mb-1">Confirmar Contraseña</label>
                        <div class="relative">
                            <input id="password_confirmation" 
                                   class="block w-full bg-slate-900 border border-slate-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl px-4 py-3 pr-12 text-sm shadow-inner placeholder-slate-500"
                                   type="password"
                                   name="password_confirmation"
                                   required 
                                   autocomplete="new-password" 
                                   placeholder="••••••••" />
                            
                            <button type="button" 
                                    onclick="togglePassword('password_confirmation', 'eye-icon-2')" 
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-white transition-colors focus:outline-none">
                                <svg id="eye-icon-2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Enlace a Login y Botón -->
                    <div class="flex items-center justify-between pt-2">
                        <a class="text-xs text-indigo-400 hover:text-indigo-300 font-medium transition-colors" href="{{ route('login') }}">
                            ¿Ya tienes una cuenta?
                        </a>

                        <button type="submit" class="py-3 px-6 bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-600/30 transition-all duration-200 cursor-pointer text-sm">
                            Registrarse
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Script JS para alternar visibilidad de contraseña -->
    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.007 10.007 0 013.682-.763c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18" />
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
</body>
</html>