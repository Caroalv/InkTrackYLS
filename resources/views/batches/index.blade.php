<x-app-layout>
    <div class="py-8 bg-slate-950 min-h-screen text-slate-100">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Encabezado de Página -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Control de Lotes de Tintas (MSDS)</h2>
                    <p class="text-xs text-slate-400 mt-1">Trazabilidad, saldos y estado de caducidad de tintas y químicos en inventario</p>
                </div>
            </div>

            <!-- MÉT RICAS Y KPIS DE LOTES -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                
                <!-- Total Lotes -->
                <a href="{{ route('batches.index') }}" 
                   class="bg-slate-900 border border-slate-800 p-4 rounded-2xl hover:border-slate-700 transition shadow-lg group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Total Lotes</p>
                            <p class="text-2xl font-bold text-white mt-1">
                                {{ isset($batches) && method_exists($batches, 'total') ? $batches->total() : (isset($batches) ? count($batches) : 0) }}
                            </p>
                        </div>
                        <div class="p-3 bg-slate-800/80 rounded-xl text-indigo-400 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Lotes Vigentes -->
                <a href="{{ route('batches.index', ['status' => 'active']) }}" 
                   class="bg-slate-900 border border-slate-800 p-4 rounded-2xl hover:border-emerald-500/30 transition shadow-lg group {{ ($status ?? '') === 'active' ? 'ring-2 ring-emerald-500/50' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Lotes Vigentes</p>
                            <p class="text-2xl font-bold text-emerald-400 mt-1">{{ $activeCount ?? 0 }}</p>
                        </div>
                        <div class="p-3 bg-emerald-500/10 rounded-xl text-emerald-400 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Próximos / Vencidos -->
                <a href="{{ route('batches.index', ['status' => 'expired']) }}" 
                   class="bg-slate-900 border border-slate-800 p-4 rounded-2xl hover:border-rose-500/30 transition shadow-lg group {{ in_array(($status ?? ''), ['expired', 'expiring']) ? 'ring-2 ring-rose-500/50' : '' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Próximos / Vencidos</p>
                            <p class="text-2xl font-bold text-rose-400 mt-1">{{ $expiredCount ?? 0 }}</p>
                        </div>
                        <div class="p-3 bg-rose-500/10 rounded-xl text-rose-400 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <!-- BUSCADOR Y FILTROS -->
            <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 shadow-xl">
                <form method="GET" action="{{ route('batches.index') }}" class="flex flex-col sm:flex-row gap-3">
                    
                    <!-- Campo Búsqueda -->
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ $search ?? '' }}" 
                               placeholder="Buscar por N° Lote MSDS o nombre de insumo..." 
                               class="w-full ps-10 bg-slate-950 border border-slate-800 text-white text-xs rounded-xl focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
                    </div>

                    <!-- Filtro Estado Vencimiento -->
                    <div class="w-full sm:w-60">
                        <select name="status" class="w-full bg-slate-950 border border-slate-800 text-white text-xs rounded-xl focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
                            <option value="">-- Todos los estados --</option>
                            <option value="active" {{ ($status ?? '') === 'active' ? 'selected' : '' }}>Vigentes (> 30 días)</option>
                            <option value="expiring" {{ ($status ?? '') === 'expiring' ? 'selected' : '' }}>Próximos a vencer (<= 30 días)</option>
                            <option value="expired" {{ ($status ?? '') === 'expired' ? 'selected' : '' }}>Vencidos</option>
                        </select>
                    </div>

                    <button type="submit" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs rounded-xl transition">
                        Buscar
                    </button>

                    @if(!empty($search) || !empty($status))
                        <a href="{{ route('batches.index') }}" class="px-4 py-2.5 bg-slate-800/50 hover:bg-slate-800 text-slate-400 font-semibold text-xs rounded-xl transition flex items-center justify-center">
                            Limpiar
                        </a>
                    @endif
                </form>
            </div>

            <!-- TABLA DE LOTES -->
            <div class="bg-slate-900 overflow-hidden shadow-2xl rounded-2xl border border-slate-800">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-300">
                        <thead class="text-xs text-slate-400 uppercase bg-slate-950/60 border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-4">Lote MSDS</th>
                                <th class="px-6 py-4">Insumo / Tinta</th>
                                <th class="px-6 py-4">Cantidad Inicial</th>
                                <th class="px-6 py-4">Saldo Actual</th>
                                <th class="px-6 py-4">Fecha Vencimiento</th>
                                <th class="px-6 py-4 text-center">Estado / Días</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($batches as $batch)
                                @php
                                    $expDate = $batch->duedate ? \Carbon\Carbon::parse($batch->duedate) : null;
                                    $today = \Carbon\Carbon::today();
                                    $daysLeft = $expDate ? (int) $today->diffInDays($expDate, false) : 0;
                                    $unitName = $batch->item->measurementUnit->unitname ?? ($batch->item->unit ?? 'unidades');
                                @endphp
                                <tr class="hover:bg-slate-800/50 transition-colors">
                                    <!-- Lote MSDS -->
                                    <td class="px-6 py-4 font-mono text-xs text-indigo-400 font-bold">
                                        {{ $batch->dyelote ?? 'SIN LOTE' }}
                                    </td>

                                    <!-- Insumo -->
                                    <td class="px-6 py-4 font-bold text-white">
                                        {{ $batch->item->itemname ?? 'Insumo #'.$batch->itemid }}
                                    </td>

                                    <!-- Cantidad Inicial -->
                                    <td class="px-6 py-4 font-mono text-xs text-slate-300">
                                        {{ number_format($batch->qtyxlote ?? 0, 2) }}
                                        <span class="text-slate-500 font-normal">{{ $unitName }}</span>
                                    </td>

                                    <!-- Saldo Actual -->
                                    <td class="px-6 py-4 font-semibold">
                                        @if(($batch->qtybalance ?? 0) <= 0)
                                            <span class="text-slate-500 font-mono text-xs">0.00</span>
                                        @else
                                            <span class="text-emerald-400 font-mono text-xs">
                                                {{ number_format($batch->qtybalance, 2) }}
                                                <span class="text-slate-400 font-normal">{{ $unitName }}</span>
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Fecha Vencimiento -->
                                    <td class="px-6 py-4 font-mono text-xs text-slate-400">
                                        {{ $expDate ? $expDate->format('d/m/Y') : '-' }}
                                    </td>

                                    <!-- Estado Semaforizado -->
                                    <td class="px-6 py-4 text-center">
                                        @if(!$expDate)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-800 text-slate-400 border border-slate-700">
                                                Sin Fecha
                                            </span>
                                        @elseif($daysLeft < 0)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/30 animate-pulse">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                </svg>
                                                <span>Vencido (hace {{ abs($daysLeft) }} d)</span>
                                            </span>
                                        @elseif($daysLeft <= 30)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                                                <span>Próximo ({{ $daysLeft }} d restantes)</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                                <span>Vigente ({{ $daysLeft }} d)</span>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                        @if(!empty($search))
                                            No se encontraron lotes que coincidan con "{{ $search }}".
                                        @elseif(!empty($status))
                                            No se encontraron lotes con el estado seleccionado.
                                        @else
                                            No hay lotes registrados en el sistema.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(isset($batches) && method_exists($batches, 'hasPages') && $batches->hasPages())
                    <div class="p-4 border-t border-slate-800">
                        {{ $batches->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>