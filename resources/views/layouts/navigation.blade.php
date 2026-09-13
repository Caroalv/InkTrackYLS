<aside class="w-64 bg-[#0b101d] text-slate-300 min-h-screen flex flex-col justify-between border-r border-slate-800/80">
    <div class="p-4 space-y-6">
        <!-- Logo -->
        <div class="px-2 py-3">
            <span class="text-xl font-black tracking-wider text-white">
                YOUNGONE
            </span>
        </div>

        <!-- Menú de Navegación -->
        <nav class="space-y-6">
            <!-- Sección GENERAL -->
            <div>
                <p class="px-2 text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">
                    GENERAL
                </p>
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-600/10 text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>
            </div>

            <!-- Sección INVENTARIO & CATÁLOGO -->
            <div>
                <p class="px-2 text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">
                    INVENTARIO & CATÁLOGO
                </p>
                <div class="space-y-1">
                    <!-- Tintas e Insumos -->
                    <a href="{{ route('items.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('items.*') ? 'bg-indigo-600/10 text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Tintas e Insumos
                    </a>

                    <!-- Grupos -->
                    <a href="{{ route('groups.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('groups.*') ? 'bg-indigo-600/10 text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Grupos
                    </a>

                    <!-- Movimientos -->
                    <a href="#" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors text-slate-400 hover:text-white hover:bg-slate-800/50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        Movimientos
                    </a>

                    <!-- Lotes de Tintas -->
                    <a href="#" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors text-slate-400 hover:text-white hover:bg-slate-800/50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        Lotes de Tintas
                    </a>
                </div>
            </div>

            <!-- Sección PARÁMETROS -->
            <div>
                <p class="px-2 text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">
                    PARÁMETROS
                </p>
                <a href="#" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors text-slate-400 hover:text-white hover:bg-slate-800/50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5 5 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Proveedores
                </a>
            </div>
        </nav>
    </div>

    <!-- Perfil / Logout inferior -->
    <div class="p-4 border-t border-slate-800/80 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-indigo-600/20 text-indigo-400 flex items-center justify-center font-bold text-sm border border-indigo-500/30">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-slate-400 hover:text-rose-400 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </form>
    </div>
</aside>