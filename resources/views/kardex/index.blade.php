<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Kárdex de Insumos</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Consulta el historial de entradas, salidas y saldo de cada insumo.</p>
            </div>

            <!-- Filtro de Selección -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
                <form method="GET" action="{{ route('kardex.index') }}" class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-semibold text-gray-400 mb-1">Seleccionar Insumo *</label>
                        <select name="item_id" class="w-full text-sm rounded-lg bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5" required>
                            <option value="">-- Seleccione un Insumo --</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}" {{ $itemId == $item->id ? 'selected' : '' }}>
                                    {{ $item->itemname }} (Stock Actual: {{ $item->currentstock }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-bold uppercase transition-colors">
                        Consultar Kárdex
                    </button>
                </form>
            </div>

            @if ($selectedItem)
                <!-- Resumen de Insumo -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-slate-900 p-4 rounded-xl border border-slate-800 text-white">
                        <span class="text-xs text-gray-400 block font-semibold">Insumo</span>
                        <span class="text-lg font-bold text-indigo-400">{{ $selectedItem->itemname }}</span>
                    </div>
                    <div class="bg-slate-900 p-4 rounded-xl border border-slate-800 text-white">
                        <span class="text-xs text-gray-400 block font-semibold">Stock Actual</span>
                        <span class="text-lg font-bold text-emerald-400">{{ $selectedItem->currentstock }}</span>
                    </div>
                    <div class="bg-slate-900 p-4 rounded-xl border border-slate-800 text-white">
                        <span class="text-xs text-gray-400 block font-semibold">Stock Mínimo</span>
                        <span class="text-lg font-bold text-amber-400">{{ $selectedItem->stockminimo ?? 0 }}</span>
                    </div>
                </div>

                <!-- Tabla de Movimientos del Kárdex -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-400 uppercase bg-slate-900 border-b border-slate-800">
                                <tr>
                                    <th class="px-4 py-3">Fecha</th>
                                    <th class="px-4 py-3">Tipo Doc.</th>
                                    <th class="px-4 py-3">N° Doc.</th>
                                    <th class="px-4 py-3 text-center">Entrada</th>
                                    <th class="px-4 py-3 text-center">Salida</th>
                                    <th class="px-4 py-3 text-center">Saldo</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-slate-950/40 text-gray-200">
                                @php $saldo = 0; @endphp
                                @forelse ($movements as $detail)
                                    @php
                                        $isInput = !is_null($detail->header->YLSindate);
                                        if ($isInput) {
                                            $saldo += $detail->qty;
                                        } else {
                                            $saldo -= $detail->qty;
                                        }
                                    @endphp
                                    <tr class="hover:bg-slate-800/40 transition-colors">
                                        <td class="px-4 py-3 text-xs">{{ $detail->header->docdate }}</td>
                                        <td class="px-4 py-3 text-xs">{{ $detail->header->docType->doctypename ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 font-mono text-xs">{{ $detail->header->docnumber }}</td>
                                        <td class="px-4 py-3 text-center font-bold text-emerald-400">
                                            {{ $isInput ? $detail->qty : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-center font-bold text-amber-400">
                                            {{ !$isInput ? $detail->qty : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-center font-bold text-indigo-300">
                                            {{ $saldo }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">No hay movimientos registrados para este insumo.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>