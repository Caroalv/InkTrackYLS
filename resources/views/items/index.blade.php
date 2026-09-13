<x-app-layout>
    <div x-data="{ 
            showCreateModal: false, 
            showEditModal: false,
            editItem: { id: null, phcode: '', itemname: '', subgroupid: '', muid: '', minstock: 0, maxstock: 0, estimatedunitweight: '' },
            openEditModal(item) {
                this.editItem = { ...item };
                this.showEditModal = true;
            }
         }" 
         class="py-8 bg-slate-950 min-h-screen text-slate-100">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Encabezado y Botón Crear -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Catálogo de Insumos</h2>
                    <p class="text-xs text-slate-400 mt-1">Gestión de insumos, materiales y parámetros de stock</p>
                </div>
                <button @click="showCreateModal = true" 
                        class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-medium text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition duration-200 group">
                    <svg class="w-4 h-4 me-2 group-hover:rotate-90 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Nuevo Insumo</span>
                </button>
            </div>

            <!-- METRICAS Y KPIS DE INVENTARIO -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Total Insumos -->
                <a href="{{ route('items.index') }}" 
                   class="bg-slate-900 border border-slate-800 p-4 rounded-2xl hover:border-slate-700 transition shadow-lg group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Total Insumos</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ $totalItems ?? 0 }}</p>
                        </div>
                        <div class="p-3 bg-slate-800/80 rounded-xl text-indigo-400 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Stock Normal -->
                <a href="{{ route('items.index', ['status' => 'normal']) }}" 
                   class="bg-slate-900 border border-slate-800 p-4 rounded-2xl hover:border-emerald-500/30 transition shadow-lg group {{ ($status ?? '') === 'normal' ? 'ring-2 ring-emerald-500/50' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Stock Óptimo</p>
                            <p class="text-2xl font-bold text-emerald-400 mt-1">{{ $normalCount ?? 0 }}</p>
                        </div>
                        <div class="p-3 bg-emerald-500/10 rounded-xl text-emerald-400 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Stock Crítico -->
                <a href="{{ route('items.index', ['status' => 'critical']) }}" 
                   class="bg-slate-900 border border-slate-800 p-4 rounded-2xl hover:border-rose-500/30 transition shadow-lg group {{ ($status ?? '') === 'critical' ? 'ring-2 ring-rose-500/50' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Stock Crítico / Bajo</p>
                            <p class="text-2xl font-bold text-rose-400 mt-1">{{ $criticalCount ?? 0 }}</p>
                        </div>
                        <div class="p-3 bg-rose-500/10 rounded-xl text-rose-400 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <!-- BUSCADOR -->
            <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 shadow-xl">
                <form method="GET" action="{{ route('items.index') }}" class="flex gap-2">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ $search ?? '' }}" 
                               placeholder="Buscar por insumo, código PH, subgrupo o grupo..." 
                               class="w-full ps-10 bg-slate-950 border border-slate-800 text-white text-xs rounded-xl focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
                    </div>
                    
                    <button type="submit" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs rounded-xl transition">
                        Buscar
                    </button>

                    @if(!empty($search) || !empty($status))
                        <a href="{{ route('items.index') }}" class="px-4 py-2.5 bg-slate-800/50 hover:bg-slate-800 text-slate-400 font-semibold text-xs rounded-xl transition flex items-center">
                            Limpiar
                        </a>
                    @endif
                </form>
            </div>

            <!-- Tabla de Insumos -->
            <div class="bg-slate-900 overflow-hidden shadow-2xl rounded-2xl border border-slate-800">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-300">
                        <thead class="text-xs text-slate-400 uppercase bg-slate-950/60 border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-4">Código PH</th>
                                <th class="px-6 py-4">Insumo</th>
                                <th class="px-6 py-4">Subgrupo / Grupo</th>
                                <th class="px-6 py-4">Stock Actual</th>
                                <th class="px-6 py-4">Límites (Mín / Máx)</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($items as $item)
                                <tr class="hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4 font-mono text-xs text-indigo-400 font-bold">{{ $item->phcode ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 font-bold text-white">{{ $item->itemname }}</td>
                                    <td class="px-6 py-4 text-xs text-slate-400">
                                        {{ $item->subgroup->subgroupname ?? '-' }}
                                        @if(isset($item->subgroup->group))
                                            <span class="text-slate-500">({{ $item->subgroup->group->groupname }})</span>
                                        @endif
                                    </td>

                                    <!-- STOCK ACTUAL CON ALERTA DE STOCK MÍNIMO -->
                                    <td class="px-6 py-4 font-semibold">
                                        @if(($item->currentstock ?? 0) <= ($item->minstock ?? 0))
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/30 animate-pulse" title="Stock en nivel crítico">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                </svg>
                                                <span>{{ $item->currentstock ?? 0 }}</span>
                                                <span class="text-[10px] opacity-75 font-normal">{{ $item->measurementUnit->unitname ?? '' }}</span>
                                            </span>
                                        @else
                                            <span class="text-emerald-400">
                                                {{ $item->currentstock ?? 0 }} 
                                                <span class="text-xs text-slate-400 font-normal">{{ $item->measurementUnit->unitname ?? '' }}</span>
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-xs text-slate-400 font-mono">
                                        {{ $item->minstock ?? 0 }} / {{ $item->maxstock ?? 0 }}
                                    </td>
                                    
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <!-- Ver Kárdex -->
                                        <a href="{{ route('kardex.index', ['item_id' => $item->id]) }}" 
                                           class="text-amber-400 hover:text-amber-300 font-medium text-xs">
                                            Kárdex
                                        </a>

                                        <!-- Editar -->
                                        <button @click="openEditModal({{ json_encode($item) }})" 
                                                class="text-indigo-400 hover:text-indigo-300 font-medium text-xs">
                                            Editar
                                        </button>

                                        <!-- Eliminar -->
                                        <form id="delete-item-{{ $item->id }}" action="{{ route('items.destroy', $item) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    onclick="confirmDelete('delete-item-{{ $item->id }}', '{{ addslashes($item->itemname) }}')"
                                                    class="text-red-400 hover:text-red-300 font-medium text-xs">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                        @if(!empty($search))
                                            No se encontraron insumos que coincidan con "{{ $search }}".
                                        @elseif(!empty($status))
                                            No se encontraron insumos con el estado seleccionado.
                                        @else
                                            No hay insumos registrados.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($items->hasPages())
                    <div class="p-4 border-t border-slate-800">
                        {{ $items->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

        </div>

        <!-- ================= MODAL CREAR INSUMO ================= -->
        <div x-show="showCreateModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showCreateModal" @click="showCreateModal = false" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity"></div>

                <div x-show="showCreateModal" class="inline-block align-bottom bg-slate-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-800">
                    <div class="p-5">
                        <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-800">
                            <h3 class="text-base font-bold text-white">Nuevo Insumo</h3>
                            <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-200 text-lg font-bold leading-none">&times;</button>
                        </div>

                        <form action="{{ route('items.store') }}" method="POST" class="space-y-3">
                            @csrf
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Código PH</label>
                                    <input type="text" name="phcode" placeholder="Ej. PH-001"
                                           class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500 font-mono">
                                </div>
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Nombre Insumo *</label>
                                    <input type="text" name="itemname" required placeholder="Ej. Tinta Negra Pigmentada"
                                           class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Subgrupo</label>
                                    <select name="subgroupid" class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Seleccionar --</option>
                                        @foreach($subgroups as $sg)
                                            <option value="{{ $sg->id }}">{{ $sg->subgroupname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Unidad Medida</label>
                                    <select name="muid" class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Seleccionar --</option>
                                        @foreach($measurementUnits as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->unitname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Stock Mínimo</label>
                                    <input type="number" step="0.01" name="minstock" value="0"
                                           class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Stock Máximo</label>
                                    <input type="number" step="0.01" name="maxstock" value="0"
                                           class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Peso Un. (Kg/L)</label>
                                    <input type="number" step="0.001" name="estimatedunitweight" placeholder="0.00"
                                           class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div class="flex items-center justify-end space-x-2 pt-4 border-t border-slate-800 mt-5">
                                <button type="button" @click="showCreateModal = false" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-semibold transition">Cancelar</button>
                                <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-semibold transition shadow-md shadow-indigo-600/30">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= MODAL EDITAR INSUMO ================= -->
        <div x-show="showEditModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showEditModal" @click="showEditModal = false" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity"></div>

                <div x-show="showEditModal" class="inline-block align-bottom bg-slate-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-800">
                    <div class="p-5">
                        <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-800">
                            <h3 class="text-base font-bold text-white">Editar Insumo</h3>
                            <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-200 text-lg font-bold leading-none">&times;</button>
                        </div>

                        <form :action="'/items/' + editItem.id" method="POST" class="space-y-3">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Código PH</label>
                                    <input type="text" name="phcode" x-model="editItem.phcode"
                                           class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500 font-mono">
                                </div>
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Nombre Insumo *</label>
                                    <input type="text" name="itemname" x-model="editItem.itemname" required
                                           class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Subgrupo</label>
                                    <select name="subgroupid" x-model="editItem.subgroupid" class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Seleccionar --</option>
                                        @foreach($subgroups as $sg)
                                            <option value="{{ $sg->id }}">{{ $sg->subgroupname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Unidad Medida</label>
                                    <select name="muid" x-model="editItem.muid" class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Seleccionar --</option>
                                        @foreach($measurementUnits as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->unitname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Stock Mínimo</label>
                                    <input type="number" step="0.01" name="minstock" x-model="editItem.minstock"
                                           class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Stock Máximo</label>
                                    <input type="number" step="0.01" name="maxstock" x-model="editItem.maxstock"
                                           class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Peso Un. (Kg/L)</label>
                                    <input type="number" step="0.001" name="estimatedunitweight" x-model="editItem.estimatedunitweight"
                                           class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div class="flex items-center justify-end space-x-2 pt-4 border-t border-slate-800 mt-5">
                                <button type="button" @click="showEditModal = false" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-semibold transition">Cancelar</button>
                                <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-semibold transition shadow-md shadow-indigo-600/30">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>