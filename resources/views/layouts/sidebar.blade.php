<aside x-data="{ openMobile: false }" class="relative">
    <!-- Overlay para pantallas móviles -->
    <div x-show="openMobile" 
         @click="openMobile = false" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-40 md:hidden"></div>

    <!-- Contenedor del Sidebar -->
    <div class="fixed top-0 bottom-0 left-0 z-50 w-64 bg-slate-900 border-r border-slate-800 flex flex-col justify-between transition-transform duration-300 md:translate-x-0"
         :class="openMobile ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
        
        <!-- Header / Logo -->
        <div>
            <div class="h-16 flex items-center px-6 border-b border-slate-800/80">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/fondo.png') }}" alt="Logo" class="h-9 w-auto object-contain">
                </a>
            </div>

            <!-- Navegación Principal -->
            <nav class="px-3 py-4 space-y-1">
                <p class="px-3 text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">General</p>
                
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-150 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <p class="px-3 text-[10px] font-semibold text-slate-500 uppercase tracking-wider mt-6 mb-2">Inventario & Catálogo</p>

                <!-- Tintas e Insumos (tblItems) -->
                <a href="{{ route('items.index') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-150 {{ request()->routeIs('items.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span>Tintas e Insumos</span>
                </a>

                <!-- Movimientos (tblMovHeader/Details) -->
                <a href=" {{  route('movements.index')  }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:text-slate-300 hover:bg-slate-800/30 transition duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    <span>Movimientos</span>
                </a>

                <!-- Control de Lotes (tblDyelotes) -->
                <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:text-slate-300 hover:bg-slate-800/30 transition duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 12h10m-7 5h7"/>
                    </svg>
                    <span>Lotes de Tintas</span>
                </a>

                <a href="{{ route('groups.index') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('groups.*') ? 'bg-indigo-600/10 text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            Grupos
        </a>


                <p class="px-3 text-[10px] font-semibold text-slate-500 uppercase tracking-wider mt-6 mb-2">Parámetros</p>

                <!-- Proveedores (tblSuppliers) -->
<!-- Proveedores (tblSuppliers) -->
        <a href="{{ route('suppliers.index') }}" 
        class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-150 {{ request()->routeIs('suppliers.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>Proveedores</span>
        </a>
            </nav>
        </div>

        <!-- Footer / Usuario y Logout -->
        <div class="p-4 border-t border-slate-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-500/20 border border-indigo-500/30 text-indigo-400 flex items-center justify-center font-bold text-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="truncate">
                        <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Cerrar Sesión" class="text-slate-400 hover:text-red-400 transition p-1.5 rounded-lg hover:bg-slate-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>