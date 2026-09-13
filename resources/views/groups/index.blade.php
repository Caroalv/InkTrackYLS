<x-app-layout>
    <div class="py-6" x-data="{
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Encabezado y Acción Principal -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-white">Grupos y Subgrupos</h2>
                    <p class="text-xs text-slate-400 mt-1">Gestión y categorización principal de materiales del sistema.</p>
                </div>
                
                <div class="flex items-center gap-2">
                    <button x-show="activeTab === 'groups'" 
                            @click="openCreateGroup = true" 
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold shadow-lg shadow-indigo-500/20 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Nuevo Grupo
                    </button>

                    <button x-show="activeTab === 'subgroups'" 
                            @click="openCreateSubgroup = true" 
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold shadow-lg shadow-indigo-500/20 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Nuevo Subgrupo
                    </button>
                </div>
            </div>

            <!-- ALERTAS NATIVAS DE FEEDBACK (ESTILO PROVEEDORES) -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-between shadow-lg backdrop-blur-sm transition-all" role="alert">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xs font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-400/70 hover:text-emerald-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 flex items-center justify-between shadow-lg backdrop-blur-sm transition-all" role="alert">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xs font-medium">{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-400/70 hover:text-rose-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 shadow-lg backdrop-blur-sm transition-all" role="alert">
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-5 h-5 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xs font-semibold">Por favor corrige los siguientes errores:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 pl-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Navegación de Pestañas (Tabs) -->
            <div class="flex border-b border-slate-800 mb-6 gap-2">
                <button @click="activeTab = 'groups'" 
                        :class="activeTab === 'groups' ? 'border-indigo-500 text-indigo-400 font-semibold' : 'border-transparent text-slate-400 hover:text-slate-300'"
                        class="py-3 px-4 text-xs border-b-2 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Grupos
                </button>
                <button @click="activeTab = 'subgroups'" 
                        :class="activeTab === 'subgroups' ? 'border-indigo-500 text-indigo-400 font-semibold' : 'border-transparent text-slate-400 hover:text-slate-300'"
                        class="py-3 px-4 text-xs border-b-2 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 12h10M7 17h10"/></svg>
                    Subgrupos
                </button>
            </div>

            <!-- Buscador Dinámico -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 mb-6">
                <form method="GET" action="{{ route('groups.index') }}" class="flex gap-2">
                    <input type="hidden" name="tab" :value="activeTab">
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}" 
                           :placeholder="activeTab === 'groups' ? 'Buscar por nombre de grupo...' : 'Buscar por nombre de subgrupo...'" 
                           class="w-full bg-slate-950 border border-slate-800 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-500">
                    <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-medium transition-all">
                        Buscar
                    </button>
                    @if($search)
                        <a href="{{ route('groups.index') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-medium transition-all flex items-center">
                            Limpiar
                        </a>
                    @endif
                </form>
            </div>

            <!-- SECCIÓN 1: TABLA DE GRUPOS -->
            <div x-show="activeTab === 'groups'" class="bg-[#0b0f19] border border-slate-800/80 rounded-2xl overflow-hidden shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="bg-transparent text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800/80">
                            <tr>
                                <th class="px-6 py-4 font-semibold">ID</th>
                                <th class="px-6 py-4 font-semibold">GRUPO</th>
                                <th class="px-6 py-4 font-semibold text-right">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/50">
                            @forelse($groups as $group)
                                <tr class="hover:bg-slate-800/20 transition-colors">
                                    <td class="px-6 py-4 font-mono text-slate-500">#{{ $group->id }}</td>
                                    <td class="px-6 py-4 font-bold text-white">{{ $group->groupname }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <button @click="setEditGroup({{ $group }})" 
                                                    class="text-indigo-400 hover:text-indigo-300 transition-colors font-medium">
                                                Editar
                                            </button>

                                            <form action="{{ route('groups.destroy', $group) }}" method="POST" class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="text-rose-500 hover:text-rose-400 transition-colors font-medium btn-delete"
                                                        data-name="{{ $group->groupname }}">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-slate-500">
                                        No se encontraron grupos registrados.
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
            <div x-show="activeTab === 'subgroups'" x-cloak class="bg-[#0b0f19] border border-slate-800/80 rounded-2xl overflow-hidden shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="bg-transparent text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800/80">
                            <tr>
                                <th class="px-6 py-4 font-semibold">ID</th>
                                <th class="px-6 py-4 font-semibold">SUBGRUPO</th>
                                <th class="px-6 py-4 font-semibold">GRUPO PERTENECIENTE</th>
                                <th class="px-6 py-4 font-semibold text-right">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/50">
                            @forelse($subgroups as $subgroup)
                                <tr class="hover:bg-slate-800/20 transition-colors">
                                    <td class="px-6 py-4 font-mono text-slate-500">#{{ $subgroup->id }}</td>
                                    <td class="px-6 py-4 font-bold text-white">{{ $subgroup->subgroupname }}</td>
                                    <td class="px-6 py-4 text-slate-400">
                                        <span class="px-2.5 py-1 rounded-lg bg-slate-800 text-slate-300 font-medium">
                                            {{ $subgroup->group->groupname ?? 'Sin Grupo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <button @click="setEditSubgroup({{ $subgroup }})" 
                                                    class="text-indigo-400 hover:text-indigo-300 transition-colors font-medium">
                                                Editar
                                            </button>

                                            <form action="{{ route('subgroups.destroy', $subgroup) }}" method="POST" class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="text-rose-500 hover:text-rose-400 transition-colors font-medium btn-delete"
                                                        data-name="{{ $subgroup->subgroupname }}">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                        No se encontraron subgrupos registrados.
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
            <div x-show="openCreateGroup" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
                <div @click.away="openCreateGroup = false" class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full p-6 shadow-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-white">Nuevo Grupo</h3>
                        <button @click="openCreateGroup = false" class="text-slate-500 hover:text-slate-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form action="{{ route('groups.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-slate-300 mb-1">Nombre del Grupo</label>
                            <input type="text" name="groupname" required placeholder="Ej. Tintas, Químicos, Solventes" class="w-full bg-slate-950 border border-slate-800 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="openCreateGroup = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs transition-colors">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold transition-colors">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Editar Grupo -->
            <div x-show="openEditGroup" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
                <div @click.away="openEditGroup = false" class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full p-6 shadow-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-white">Editar Grupo</h3>
                        <button @click="openEditGroup = false" class="text-slate-500 hover:text-slate-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form :action="'{{ url('groups') }}/' + editGroup.id" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-slate-300 mb-1">Nombre del Grupo</label>
                            <input type="text" name="groupname" x-model="editGroup.groupname" required class="w-full bg-slate-950 border border-slate-800 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="openEditGroup = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs transition-colors">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold transition-colors">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Crear Subgrupo -->
            <div x-show="openCreateSubgroup" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
                <div @click.away="openCreateSubgroup = false" class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full p-6 shadow-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-white">Nuevo Subgrupo</h3>
                        <button @click="openCreateSubgroup = false" class="text-slate-500 hover:text-slate-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form action="{{ route('subgroups.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-slate-300 mb-1">Grupo Perteneciente</label>
                            <select name="groupid" required class="w-full bg-slate-950 border border-slate-800 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" disabled selected>Seleccione un grupo...</option>
                                @foreach($allGroups as $g)
                                    <option value="{{ $g->id }}">{{ $g->groupname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-medium text-slate-300 mb-1">Nombre del Subgrupo</label>
                            <input type="text" name="subgroupname" required placeholder="Ej. Plastisol, Base Agua" class="w-full bg-slate-950 border border-slate-800 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="openCreateSubgroup = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs transition-colors">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold transition-colors">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Editar Subgrupo -->
            <div x-show="openEditSubgroup" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
                <div @click.away="openEditSubgroup = false" class="bg-slate-900 border border-slate-800 rounded-2xl max-w-md w-full p-6 shadow-2xl">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-white">Editar Subgrupo</h3>
                        <button @click="openEditSubgroup = false" class="text-slate-500 hover:text-slate-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form :action="'{{ url('groups/subgroups') }}/' + editSubgroup.id" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-slate-300 mb-1">Grupo Perteneciente</label>
                            <select name="groupid" x-model="editSubgroup.groupid" required class="w-full bg-slate-950 border border-slate-800 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($allGroups as $g)
                                    <option value="{{ $g->id }}">{{ $g->groupname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-medium text-slate-300 mb-1">Nombre del Subgrupo</label>
                            <input type="text" name="subgroupname" x-model="editSubgroup.subgroupname" required class="w-full bg-slate-950 border border-slate-800 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="openEditSubgroup = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs transition-colors">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold transition-colors">Actualizar</button>
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
                        background: '#0b0f19',
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