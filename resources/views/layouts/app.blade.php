<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <title>{{ config('app.name', 'Laravel') }}</title>
                <style>
        [x-cloak] { 
                display: none !important; 
            }
            </style>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-100 min-h-screen">
        <div class="min-h-screen bg-slate-950 flex">
            <!-- Sidebar Navigation -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex-1 md:pl-64 flex flex-col min-h-screen transition-all duration-300">
                <!-- Top Navbar (Solo móvil / Búsqueda rápida) -->
                <header class="h-16 bg-slate-900/80 backdrop-blur-md border-b border-slate-800 flex items-center justify-between px-4 sm:px-6 md:hidden sticky top-0 z-40">
                    <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/fondo.png') }} " alt="Logo" width="10"> 
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>

    <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script Global de Alertas -->
<script>
    // Toast de éxito global
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            background: '#0f172a',
            color: '#f8fafc',
            customClass: {
                popup: 'border border-slate-800 rounded-xl shadow-xl'
            }
        });
    @endif

    // Toast de error global (opcional)
    @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: '#0f172a',
            color: '#f8fafc',
            customClass: {
                popup: 'border border-slate-800 rounded-xl shadow-xl'
            }
        });
    @endif

    // Función global reutilizable para confirmar eliminación
    function confirmDelete(formId, itemName = 'este registro') {
        Swal.fire({
            title: '¿Eliminar registro?',
            text: `¿Estás seguro de eliminar "${itemName}"? Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#334155',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            background: '#0f172a',
            color: '#f8fafc',
            customClass: {
                popup: 'border border-slate-800 rounded-2xl shadow-2xl',
                confirmButton: 'px-4 py-2 text-xs font-semibold rounded-xl',
                cancelButton: 'px-4 py-2 text-xs font-semibold rounded-xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
</html>