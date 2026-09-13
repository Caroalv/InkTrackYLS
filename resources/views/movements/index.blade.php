<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Mensajes de Estado (Alertas Nativas) -->
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800" role="alert">
                    <span class="font-medium">¡Éxito!</span> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-200 dark:border-red-800" role="alert">
                    <span class="font-medium">¡Atención!</span> {{ session('error') }}
                </div>
            @endif

            <!-- Encabezado y Acción -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Movimientos de Inventario</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Gestión de entradas y salidas de stock.</p>
                </div>
                
                <button x-data x-on:click="$dispatch('open-modal', 'create-movement-modal')"
                    class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Nuevo Movimiento
                </button>
            </div>

            <!-- Tabla de Historial de Movimientos -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <form method="GET" action="{{ route('movements.index') }}" class="flex gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por N° Documento o Proveedor..."
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-lg text-xs font-semibold uppercase hover:bg-gray-700">
                            Buscar
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50/50 dark:bg-gray-700/50 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-3">ID</th>
                                <th scope="col" class="px-6 py-3">Fecha Doc.</th>
                                <th scope="col" class="px-6 py-3">Tipo Doc.</th>
                                <th scope="col" class="px-6 py-3">N° Documento</th>
                                <th scope="col" class="px-6 py-3">Proveedor</th>
                                <th scope="col" class="px-6 py-3">Items</th>
                                <th scope="col" class="px-6 py-3">Tipo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($movements as $mov)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">#{{ $mov->id }}</td>
                                    <td class="px-6 py-4">{{ $mov->docdate }}</td>
                                    <td class="px-6 py-4">{{ $mov->docType->doctypename ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 font-mono">{{ $mov->docnumber ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $mov->supplier->suppliername ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            {{ $mov->details->count() }} artículo(s)
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($mov->YLSindate)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                ENTRADA
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                                                SALIDA
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-400">No se encontraron movimientos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $movements->links() }}
                </div>
            </div>

            <!-- Modal para Nuevo Movimiento con Diseño Obscuro Integrado -->
            <x-modal name="create-movement-modal" focusable>
                <div x-data="{
                    movtype: 'IN',
                    rows: [{ item_id: '', qty: 1, realweight: '' }],
                    addRow() {
                        this.rows.push({ item_id: '', qty: 1, realweight: '' });
                    },
                    removeRow(index) {
                        if (this.rows.length > 1) {
                            this.rows.splice(index, 1);
                        }
                    }
                }" class="p-6 bg-[#0f172a] text-gray-200 border border-slate-800 rounded-2xl relative shadow-2xl">

                    <!-- Botón Cierre X -->
                    <button x-on:click="$dispatch('close')" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <h2 class="text-lg font-bold text-white mb-6">
                        Registrar Movimiento de Inventario
                    </h2>

                    <form method="POST" action="{{ route('movements.store') }}" class="space-y-4">
                        @csrf

                        <!-- Fila 1: Tipo y Fecha -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-300 mb-1">Tipo de Movimiento *</label>
                                <select name="movtype" x-model="movtype" class="w-full text-xs rounded-lg bg-[#080d1a] border border-slate-700 text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                                    <option value="IN">Entrada (Ingreso de Stock)</option>
                                    <option value="OUT">Salida (Egreso/Consumo)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-300 mb-1">Fecha de Documento *</label>
                                <input type="date" name="docdate" value="{{ date('Y-m-d') }}" class="w-full text-xs rounded-lg bg-[#080d1a] border border-slate-700 text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5" required />
                            </div>
                        </div>

                        <!-- Fila 2: Tipo Doc, N° Documento y Proveedor -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-300 mb-1">Tipo Documento *</label>
                                <select name="doctypeid" id="doctypeid" class="w-full text-xs rounded-lg bg-[#080d1a] border border-slate-700 text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5" required>
                                    <option value="">-- Seleccionar --</option>
                                    @foreach ($docTypes as $doc)
                                        <option value="{{ $doc->id }}">{{ $doc->doctypename ?? $doc->name ?? 'Doc #'.$doc->id }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-300 mb-1">N° Documento *</label>
                                <input type="text" name="docnumber" placeholder="Ej: REC-2026-001" class="w-full text-xs rounded-lg bg-[#080d1a] border border-slate-700 text-white placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 p-2.5" required />
                            </div>

                            <div x-show="movtype === 'IN'">
                                <label class="block text-xs font-semibold text-gray-300 mb-1">Proveedor</label>
                                <select name="supplierid" id="supplierid" class="w-full text-xs rounded-lg bg-[#080d1a] border border-slate-700 text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach ($suppliers as $sup)
                                        <option value="{{ $sup->id }}">{{ $sup->suppliername }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Detalle Dinámico de Insumos -->
                        <div class="pt-4 border-t border-slate-800">
                            <div class="flex justify-between items-center mb-3">
                                <label class="text-xs font-bold text-gray-300 uppercase tracking-wider">Detalle de Insumos</label>
                                <button type="button" @click="addRow()" class="px-3 py-1.5 text-xs bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-medium transition-colors">
                                    + Agregar Insumo
                                </button>
                            </div>

                            <div class="space-y-3">
                                <template x-for="(row, index) in rows" :key="index">
                                    <div class="flex flex-col sm:flex-row gap-2 items-center bg-[#080d1a]/60 p-3 rounded-xl border border-slate-800">
                                        
                                        <div class="flex-1 w-full">
                                            <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Insumo *</label>
                                            <select :name="`items[${index}][id]`" x-model="row.item_id" class="w-full text-xs rounded-lg bg-[#080d1a] border border-slate-700 text-white focus:ring-indigo-500 focus:border-indigo-500 p-2" required>
                                                <option value="">-- Seleccionar --</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->itemname }} (Stock: {{ $item->currentstock }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="w-full sm:w-28">
                                            <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Cantidad *</label>
                                            <input type="number" step="0.01" min="0.01" :name="`items[${index}][qty]`" x-model="row.qty" class="w-full text-xs rounded-lg bg-[#080d1a] border border-slate-700 text-white text-center focus:ring-indigo-500 focus:border-indigo-500 p-2" required />
                                        </div>

                                        <div class="w-full sm:w-28">
                                            <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Peso Real</label>
                                            <input type="number" step="0.01" min="0" :name="`items[${index}][realweight]`" x-model="row.realweight" class="w-full text-xs rounded-lg bg-[#080d1a] border border-slate-700 text-white text-center placeholder-gray-600 focus:ring-indigo-500 focus:border-indigo-500 p-2" placeholder="0.00" />
                                        </div>

                                        <div class="sm:pt-4">
                                            <button type="button" @click="removeRow(index)" x-show="rows.length > 1" class="p-1.5 text-gray-500 hover:text-red-400 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="pt-4 border-t border-slate-800 flex justify-end gap-3">
                            <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-gray-300 rounded-lg transition-colors">
                                Cancelar
                            </button>
                            <button type="submit" class="px-4 py-2 text-xs font-semibold bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg shadow-lg shadow-indigo-600/30 transition-colors">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </x-modal>

        </div>
    </div>
</x-app-layout>