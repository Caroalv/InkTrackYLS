<x-app-layout>
    <div class="py-10 bg-slate-50/50 dark:bg-slate-950/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Mensajes de Estado -->
            @if (session('success'))
                <div class="flex items-center gap-3 p-4 text-sm text-emerald-800 dark:text-emerald-300 rounded-2xl bg-emerald-50/80 dark:bg-emerald-950/30 border border-emerald-200/80 dark:border-emerald-800/50 shadow-sm backdrop-blur-sm" role="alert">
                    <div class="p-1.5 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <span class="font-semibold">¡Éxito!</span> {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="flex items-center gap-3 p-4 text-sm text-rose-800 dark:text-rose-300 rounded-2xl bg-rose-50/80 dark:bg-rose-950/30 border border-rose-200/80 dark:border-rose-800/50 shadow-sm backdrop-blur-sm" role="alert">
                    <div class="p-1.5 rounded-xl bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <span class="font-semibold">¡Atención!</span> {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Encabezado -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-slate-200/60 dark:border-slate-800/60">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Movimientos de Inventario</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Gestión integral de entradas y salidas de stock.</p>
                </div>
                
                <button x-data x-on:click="$dispatch('open-modal', 'create-movement-modal')"
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 text-white font-medium text-xs tracking-wider uppercase rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/35 active:scale-[0.98] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    <svg class="w-4 h-4 mr-2 -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Nuevo Movimiento
                </button>
            </div>

            <!-- Tabla de Historial -->
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl shadow-xl shadow-slate-200/50 dark:shadow-none rounded-3xl border border-slate-200/80 dark:border-slate-800 overflow-hidden transition-all">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800/80 bg-slate-50/50 dark:bg-slate-900/50">
                    <form method="GET" action="{{ route('movements.index') }}" class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Buscar por N° Documento o Proveedor..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-200 dark:border-slate-700/80 bg-white dark:bg-slate-800/80 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm transition-all duration-200 shadow-sm">
                        </div>
                        <button type="submit" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 text-white rounded-xl text-xs font-semibold uppercase tracking-wider shadow-md transition-all duration-200 active:scale-[0.98]">
                            Buscar
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600 dark:text-slate-300">
                        <thead class="text-[11px] uppercase tracking-wider text-slate-400 dark:text-slate-400 bg-slate-50/80 dark:bg-slate-800/40 font-bold border-b border-slate-100 dark:border-slate-800">
                            <tr>
                                <th scope="col" class="px-6 py-4">ID</th>
                                <th scope="col" class="px-6 py-4">Fecha Doc.</th>
                                <th scope="col" class="px-6 py-4">Tipo Doc.</th>
                                <th scope="col" class="px-6 py-4">N° Documento</th>
                                <th scope="col" class="px-6 py-4">Proveedor</th>
                                <th scope="col" class="px-6 py-4">Items</th>
                                <th scope="col" class="px-6 py-4">Tipo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                            <?php if (isset($movements) && count($movements) > 0): ?>
                                <?php foreach ($movements as$mov): ?>
                                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors duration-150">
                                        <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">#{{ $mov->id }}</td>
                                        <td class="px-6 py-4 font-medium whitespace-nowrap">{{ $mov->docdate }}</td>
                                        <td class="px-6 py-4 font-medium">{{ $mov->docType->doctypename ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 font-mono text-xs font-semibold text-slate-700 dark:text-slate-300">{{ $mov->docnumber ?? '-' }}</td>
                                        <td class="px-6 py-4 font-medium">{{ $mov->supplier->suppliername ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 ring-1 ring-inset ring-slate-500/10">
                                                {{ $mov->details ? $mov->details->count() : 0 }} artículo(s)
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($mov->YLSindate)
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 ring-1 ring-inset ring-emerald-600/20">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    ENTRADA
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400 ring-1 ring-inset ring-amber-600/20">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                    SALIDA
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-slate-400 dark:text-slate-500">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-8 h-8 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                            <span>No se encontraron movimientos registrados.</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                @if (isset($movements) && method_exists($movements, 'links'))
                    <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-900/30">
                        {{ $movements->links() }}
                    </div>
                @endif
            </div>

            <!-- Modal Nuevo Movimiento -->
            <x-modal name="create-movement-modal" focusable>
                <div x-data="{
                    movtype: 'IN',
                    rows: [{ item_id: '', qty: 1, realweight: '', batch_number: '', expiration_date: '' }],
                    addRow() {
                        this.rows.push({ item_id: '', qty: 1, realweight: '', batch_number: '', expiration_date: '' });
                    },
                    removeRow(index) {
                        if (this.rows.length > 1) {
                            this.rows.splice(index, 1);
                        }
                    }
                }" class="p-6 sm:p-8 bg-slate-900 text-slate-200 border border-slate-800 rounded-3xl relative shadow-2xl overflow-hidden">

                    <button x-on:click="$dispatch('close')" class="absolute top-5 right-5 p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-white tracking-tight">Registrar Movimiento de Inventario</h2>
                        <p class="text-xs text-slate-400 mt-1">Completa los campos para ingresar o retirar material.</p>
                    </div>

                    <form method="POST" action="{{ route('movements.store') }}" class="space-y-5">
                        @csrf

                        <!-- Tipo y Fecha -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Tipo de Movimiento *</label>
                                <select name="movtype" x-model="movtype" class="w-full text-xs font-medium rounded-xl bg-slate-950 border border-slate-800 text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 p-3 transition-all">
                                    <option value="IN">Entrada (Ingreso de Stock)</option>
                                    <option value="OUT">Salida (Egreso/Consumo)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Fecha de Documento *</label>
                                <input type="date" name="docdate" value="{{ date('Y-m-d') }}" class="w-full text-xs font-medium rounded-xl bg-slate-950 border border-slate-800 text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 p-3 transition-all" required />
                            </div>
                        </div>

                        <!-- Tipo Doc, N° Documento y Proveedor -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Tipo Documento *</label>
                                <select name="doctypeid" class="w-full text-xs font-medium rounded-xl bg-slate-950 border border-slate-800 text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 p-3 transition-all" required>
                                    <option value="">-- Seleccionar --</option>
                                    <?php if (isset($docTypes)): ?>
                                        <?php foreach ($docTypes as$doc): ?>
                                            <option value="{{ $doc->id }}">{{ $doc->doctypename ?? $doc->name ?? 'Doc #'.$doc->id }}</option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">N° Documento *</label>
                                <input type="text" name="docnumber" placeholder="Ej: REC-2026-001" class="w-full text-xs font-medium rounded-xl bg-slate-950 border border-slate-800 text-white placeholder-slate-600 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 p-3 transition-all" required />
                            </div>

                            <div x-show="movtype === 'IN'">
                                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Proveedor</label>
                                <select name="supplierid" class="w-full text-xs font-medium rounded-xl bg-slate-950 border border-slate-800 text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 p-3 transition-all">
                                    <option value="">-- Seleccionar --</option>
                                    <?php if (isset($suppliers)): ?>
                                        <?php foreach ($suppliers as$sup): ?>
                                            <option value="{{ $sup->id }}">{{ $sup->suppliername }}</option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Detalle Dinámico de Insumos -->
                        <div class="pt-5 border-t border-slate-800/80">
                            <div class="flex justify-between items-center mb-4">
                                <label class="text-xs font-bold text-slate-300 uppercase tracking-wider">Detalle de Insumos</label>
                                <button type="button" @click="addRow()" class="px-3.5 py-1.5 text-xs bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-300 border border-indigo-500/30 hover:border-indigo-500/50 rounded-xl font-medium transition-all duration-200">
                                    + Agregar Insumo
                                </button>
                            </div>

                            <div class="space-y-3 max-h-80 overflow-y-auto pr-1">
                                <template x-for="(row, index) in rows" :key="index">
                                    <div class="flex flex-col gap-3 bg-slate-950/70 p-4 rounded-2xl border border-slate-800/80 shadow-inner">
                                        
                                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                                            <div class="sm:col-span-6">
                                                <label class="block text-[10px] uppercase font-bold text-slate-400 mb-1 tracking-wider">Insumo *</label>
                                                <select :name="`items[${index}][id]`" x-model="row.item_id" class="w-full text-xs rounded-xl bg-slate-900 border border-slate-800 text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 p-2.5 transition-all" required>
                                                    <option value="">-- Seleccionar --</option>
                                                    <?php if (isset($items)): ?>
                                                        <?php foreach ($items as$item): ?>
                                                            <option value="{{ $item->id }}">{{ $item->itemname }} (Stock: {{$item->currentstock }})</option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-[10px] uppercase font-bold text-slate-400 mb-1 tracking-wider">Cantidad *</label>
                                                <input type="number" step="0.01" min="0.01" :name="`items[${index}][qty]`" x-model="row.qty" class="w-full text-xs rounded-xl bg-slate-900 border border-slate-800 text-white text-center focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 p-2.5 transition-all" required />
                                            </div>

                                            <div class="sm:col-span-2">
                                                <label class="block text-[10px] uppercase font-bold text-slate-400 mb-1 tracking-wider">Peso Real</label>
                                                <input type="number" step="0.01" min="0" :name="`items[${index}][realweight]`" x-model="row.realweight" class="w-full text-xs rounded-xl bg-slate-900 border border-slate-800 text-white text-center p-2.5 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" placeholder="0.00" />
                                            </div>

                                            <div class="sm:col-span-1 text-right sm:pt-4">
                                                <button type="button" @click="removeRow(index)" x-show="rows.length > 1" class="p-2 text-slate-500 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition-all duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Campos adicionales para Entradas -->
                                        <div x-show="movtype === 'IN'" class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-3 border-t border-slate-800/60">
                                            <div>
                                                <label class="block text-[10px] uppercase font-bold text-indigo-400 mb-1 tracking-wider">Lote MSDS *</label>
                                                <input type="text" :name="`items[${index}][batch_number]`" x-model="row.batch_number" :required="movtype === 'IN'" placeholder="Ej: LOTE-2026-A" class="w-full text-xs rounded-xl bg-slate-900 border border-slate-800 text-white placeholder-slate-600 p-2.5 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" />
                                            </div>
                                            <div>
                                                <label class="block text-[10px] uppercase font-bold text-indigo-400 mb-1 tracking-wider">Fecha Vencimiento *</label>
                                                <input type="date" :name="`items[${index}][expiration_date]`" x-model="row.expiration_date" :required="movtype === 'IN'" class="w-full text-xs rounded-xl bg-slate-900 border border-slate-800 text-white p-2.5 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" />
                                            </div>
                                        </div>

                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="pt-5 border-t border-slate-800 flex justify-end gap-3">
                            <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl transition-all duration-200">
                                Cancelar
                            </button>
                            <button type="submit" class="px-5 py-2.5 text-xs font-semibold bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl shadow-lg shadow-indigo-500/20 active:scale-[0.98] transition-all duration-200">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </x-modal>

        </div>
    </div>
</x-app-layout>