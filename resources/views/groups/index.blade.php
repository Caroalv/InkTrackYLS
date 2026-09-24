<x-app-layout>
    <div class="py-8 bg-slate-950 min-h-screen text-slate-100" x-data="{
        activeTab: '{{ $tab ?? 'groups' }}',
        openCreateGroup: false,
        openEditGroup: false,
        editGroup: { id: null, groupname: '' },
        
        openCreateSubgroup: false,
        openEditSubgroup: false,
        editSubgroup: { id: null, subgroupname: '', groupid: '' },

        setEditGroup(group) {
            this.editGroup = { ...group };
            this.openEditGroup = true;
        },

        setEditSubgroup(subgroup) {
            this.editSubgroup = { 
                id: subgroup.id, 
                subgroupname: subgroup.subgroupname, 
                groupid: subgroup.groupid 
            };
            this.openEditSubgroup = true;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Encabezado y Acción Principal -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                        <span class="p-2 rounded-xl bg-slate-800/80 text-indigo-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </span>
                        Grupos y Subgrupos
                    </h2>
                    <p class="text-xs text-slate-400 mt-1">Gestión y categorización principal de materiales del sistema.</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <button x-show="activeTab === 'groups'" 
                            @click="openCreateGroup = true" 
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-medium shadow-lg shadow-indigo-600/30 transition duration-200 cursor-pointer">
                        <svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Nuevo Grupo
                    </button>

                    <button x-show="activeTab === 'subgroups'" 
                            @click="openCreateSubgroup = true" 
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-medium shadow-lg shadow-indigo-600/30 transition duration-200 cursor-pointer">
                        <svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Nuevo Subgrupo
                    </button>
                </div>
            </div>

            <!-- ALERTAS NATIVAS DE FEEDBACK -->
            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-between shadow-lg transition" role="alert">
                    <div class="flex items-center gap-3">
                        <div class="p-1 rounded-lg bg-emerald-500/20">
                            <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium tracking-wide">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="p-1 rounded-lg hover:bg-emerald-500/20 text-emerald-400/70 hover:text-emerald-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 flex items-center justify-between shadow-lg transition" role="alert">
                    <div class="flex items-center gap-3">
                        <div class="p-1 rounded-lg bg-rose-500/20">
                            <svg class="w-5 h-5 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-medium tracking-wide">{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="p-1 rounded-lg hover:bg-rose-500/20 text-rose-400/70 hover:text-rose-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 shadow-lg transition" role="alert">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-1 rounded-lg bg-rose-500/20">
                            <svg class="w-5 h-5 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-wider">Por favor corrige los siguientes errores:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 pl-2 text-rose-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Navegación de Pestañas (Tabs) -->
            <div class="flex p-1 space-x-2 bg-slate-900 rounded-2xl border border-slate-800 w-fit">
                <button @click="activeTab = 'groups'" 
                        :class="activeTab === 'groups' ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800'"
                        class="px-5 py-2.5 text-xs rounded-xl transition duration-200 flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Grupos
                </button>
                <button @click="activeTab = 'subgroups'" 
                        :class="activeTab === 'subgroups' ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800'"
                        class="px-5 py-2.5 text-xs rounded-xl transition duration-200 flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 12h10M7 17h10"/></svg>
                    Subgrupos
                </button>
            </div>

            <!-- Buscador Dinámico -->
            <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 shadow-xl">
                <form method="GET" action="{{ route('groups.index') }}" class="flex items-center gap-3">
                    <input type="hidden" name="tab" :value="activeTab">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}" 
                               :placeholder="activeTab === 'groups' ? 'Buscar por nombre de grupo...' : 'Buscar por nombre de subgrupo...'" 
                               class="w-full bg-slate-950 border border-slate-800 text-white placeholder-slate-500 rounded-xl pl-10 pr-4 py-2.5 text-xs focus:border-indigo-500 focus:ring-indigo-500 outline-none transition">
                    </div>
                    <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl text-xs font-medium transition duration-200 cursor-pointer flex-shrink-0">
                        Buscar
                    </button>
                    @if($search)
                        <a href="{{ route('groups.index') }}" class="px-4 py-2.5 bg-slate-800/50 hover:bg-slate-800 text-slate-400 rounded-xl text-xs font-semibold transition flex items-center flex-shrink-0">
                            Limpiar
                        </a>
                    @endif
                </form>
            </div>

            <!-- SECCIÓN 1: TABLA DE GRUPOS -->
            <div x-show="activeTab === 'groups'" class="bg-slate-900 overflow-hidden shadow-2xl rounded-2xl border border-slate-800">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-300">
                        <thead class="text-xs text-slate-400 uppercase bg-slate-950/60 border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">GRUPO</th>
                                <th class="px-6 py-4 text-right">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($groups as $group)
                                <tr class="hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4 font-mono text-slate-500 font-medium">#{{ $group->id }}</td>
                                    <td class="px-6 py-4 font-bold text-white">{{ $group->groupname }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <button @click="setEditGroup({{ $group }})" 
                                                    class="text-indigo-400 hover:text-indigo-300 font-medium text-xs">
                                                Editar
                                            </button>

                                            <form action="{{ route('groups.destroy', $group) }}" method="POST" class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="text-red-400 hover:text-red-300 font-medium text-xs btn-delete cursor-pointer"
                                                        data-name="{{ $group->groupname }}">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                            <span>No se encontraron grupos registrados.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($groups->hasPages())
                    <div class="p-4 border-t border-slate-800">
                        {{ $groups->links() }}
                    </div>
                @endif
            </div>

            <!-- SECCIÓN 2: TABLA DE SUBGRUPOS -->
            <div x-show="activeTab === 'subgroups'" x-cloak class="bg-slate-900 overflow-hidden shadow-2xl rounded-2xl border border-slate-800">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-300">
                        <thead class="text-xs text-slate-400 uppercase bg-slate-950/60 border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">SUBGRUPO</th>
                                <th class="px-6 py-4">GRUPO PERTENECIENTE</th>
                                <th class="px-6 py-4 text-right">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($subgroups as $subgroup)
                                <tr class="hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4 font-mono text-slate-500 font-medium">#{{ $subgroup->id }}</td>
                                    <td class="px-6 py-4 font-bold text-white">{{ $subgroup->subgroupname }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-800 text-slate-300 font-medium">
                                            {{ $subgroup->group->groupname ?? 'Sin Grupo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <button @click="setEditSubgroup({{ $subgroup }})" 
                                                    class="text-indigo-400 hover:text-indigo-300 font-medium text-xs">
                                                Editar
                                            </button>

                                            <form action="{{ route('subgroups.destroy', $subgroup) }}" method="POST" class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="text-red-400 hover:text-red-300 font-medium text-xs btn-delete cursor-pointer"
                                                        data-name="{{ $subgroup->subgroupname }}">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                            <span>No se encontraron subgrupos registrados.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($subgroups->hasPages())
                    <div class="p-4 border-t border-slate-800">
                        {{ $subgroups->links() }}
                    </div>
                @endif
            </div>

            <!-- Modal Crear Grupo -->
            <div x-show="openCreateGroup" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950 backdrop-blur-sm flex items-center justify-center p-4">
                <div @click.away="openCreateGroup = false" class="bg-slate-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition max-w-md w-full border border-slate-800">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-white">
                            Nuevo Grupo
                        </h3>
                        <button @click="openCreateGroup = false" class="text-slate-400 hover:text-slate-200 text-lg font-bold leading-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form action="{{ route('groups.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-slate-300 font-medium text-xs mb-1">Nombre del Grupo</label>
                            <input type="text" name="groupname" required placeholder="Ej. Tintas, Químicos, Solventes" class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500 outline-none transition">
                        </div>

                        <div class="flex items-center justify-end space-x-2 pt-4 border-t border-slate-800 mt-5">
                            <button type="button" @click="openCreateGroup = false" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-semibold transition">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-medium shadow-lg shadow-indigo-600/30 transition-colors cursor-pointer">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Editar Grupo -->
            <div x-show="openEditGroup" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950 backdrop-blur-sm flex items-center justify-center p-4">
                <div @click.away="openEditGroup = false" class="bg-slate-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition max-w-md w-full border border-slate-800">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-white">
                            Editar Grupo
                        </h3>
                        <button @click="openEditGroup = false" class="text-slate-400 hover:text-slate-200 text-lg font-bold leading-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form :action="'{{ url('groups') }}/' + editGroup.id" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-slate-300 font-medium text-xs mb-1">Nombre del Grupo</label>
                            <input type="text" name="groupname" x-model="editGroup.groupname" required class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500 outline-none transition">
                        </div>

                        <div class="flex items-center justify-end space-x-2 pt-4 border-t border-slate-800 mt-5">
                            <button type="button" @click="openEditGroup = false" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-semibold transition">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-medium shadow-lg shadow-indigo-600/30 transition-colors cursor-pointer">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Crear Subgrupo -->
            <div x-show="openCreateSubgroup" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950 backdrop-blur-sm flex items-center justify-center p-4">
                <div @click.away="openCreateSubgroup = false" class="bg-slate-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition max-w-md w-full border border-slate-800">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-white">
                            Nuevo Subgrupo
                        </h3>
                        <button @click="openCreateSubgroup = false" class="text-slate-400 hover:text-slate-200 text-lg font-bold leading-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form action="{{ route('subgroups.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-slate-300 font-medium text-xs mb-1">Grupo Perteneciente</label>
                            <select name="groupid" required class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500 outline-none transition">
                                <option value="" disabled selected>Seleccione un grupo...</option>
                                @foreach($allGroups as $g)
                                    <option value="{{ $g->id }}">{{ $g->groupname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-slate-300 font-medium text-xs mb-1">Nombre del Subgrupo</label>
                            <input type="text" name="subgroupname" required placeholder="Ej. Plastisol, Base Agua" class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500 outline-none transition">
                        </div>

                        <div class="flex items-center justify-end space-x-2 pt-4 border-t border-slate-800 mt-5">
                            <button type="button" @click="openCreateSubgroup = false" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-semibold transition">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-medium shadow-lg shadow-indigo-600/30 transition-colors cursor-pointer">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Editar Subgrupo -->
            <div x-show="openEditSubgroup" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950 backdrop-blur-sm flex items-center justify-center p-4">
                <div @click.away="openEditSubgroup = false" class="bg-slate-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition max-w-md w-full border border-slate-800">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-white">
                            Editar Subgrupo
                        </h3>
                        <button @click="openEditSubgroup = false" class="text-slate-400 hover:text-slate-200 text-lg font-bold leading-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form :action="'{{ url('groups/subgroups') }}/' + editSubgroup.id" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-slate-300 font-medium text-xs mb-1">Grupo Perteneciente</label>
                            <select name="groupid" x-model="editSubgroup.groupid" required class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500 outline-none transition">
                                @foreach($allGroups as $g)
                                    <option value="{{ $g->id }}">{{ $g->groupname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-slate-300 font-medium text-xs mb-1">Nombre del Subgrupo</label>
                            <input type="text" name="subgroupname" x-model="editSubgroup.subgroupname" required class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500 outline-none transition">
                        </div>

                        <div class="flex items-center justify-end space-x-2 pt-4 border-t border-slate-800 mt-5">
                            <button type="button" @click="openEditSubgroup = false" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-semibold transition">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-medium shadow-lg shadow-indigo-600/30 transition-colors cursor-pointer">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Script para SweetAlert2 de confirmación al eliminar -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('.delete-form');
                    const name = this.getAttribute('data-name');

                    Swal.fire({
                        title: '¿Eliminar registro?',
                        text: `Se eliminará "${name}". Esta acción no se puede deshacer.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#334155',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        background: '#0f172a',
                        color: '#fff'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>