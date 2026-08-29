<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Control de Inventario de Tintas') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Tarjetas de Resumen (KPIs) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800 shadow-xl flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Insumos</p>
                        <h3 class="text-3xl font-extrabold text-white mt-1">{{ $items->count() }}</h3>
                    </div>
                    <div class="p-3 bg-indigo-600/20 text-indigo-400 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m-8-10l-8-4m0 4v10l8 4"></path></svg>
                    </div>
                </div>

                <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800 shadow-xl flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Stock Crítico</p>
                        <h3 class="text-3xl font-extrabold text-amber-400 mt-1">
                            {{ $items->filter(fn($i) => $i->currentstock <= $i->minstock)->count() }}
                        </h3>
                    </div>
                    <div class="p-3 bg-amber-500/20 text-amber-400 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>

                <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800 shadow-xl flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Fecha Actual</p>
                        <h3 class="text-xl font-bold text-slate-200 mt-1">{{ date('d/m/Y') }}</h3>
                    </div>
                    <div class="p-3 bg-emerald-500/20 text-emerald-400 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Tabla Principal de Insumos -->
            <div class="bg-slate-900 overflow-hidden shadow-2xl rounded-2xl border border-slate-800">
                <div class="p-6 border-b border-slate-800 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-white">Listado de Tintas e Insumos</h3>
                        <p class="text-xs text-slate-400">Monitoreo de existencias, pesos y fechas MSDS</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-300">
                        <thead class="text-xs text-slate-400 uppercase bg-slate-950/60 border-b border-slate-800">
                            <tr>
                                <th scope="col" class="px-6 py-4">Código PH</th>
                                <th scope="col" class="px-6 py-4">Grupo / Subgrupo</th>
                                <th scope="col" class="px-6 py-4">Nombre Insumo</th>
                                <th scope="col" class="px-6 py-4 text-center">U/M</th>
                                <th scope="col" class="px-6 py-4 text-center">Fecha MSDS</th>
                                <th scope="col" class="px-6 py-4 text-center">Stock Actual</th>
                                <th scope="col" class="px-6 py-4 text-center">Estado Stock</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($items as $item)
                                @php
                                    $dyelote = $item->dyelotes->first();
                                @endphp
                                <tr class="hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4 font-mono font-medium text-indigo-400">
                                        {{ $item->phcode ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-white">{{ $item->subgroup->group->groupname ?? '-' }}</div>
                                        <div class="text-xs text-slate-400">{{ $item->subgroup->subgroupname ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-white">
                                        {{ $item->itemname }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2.5 py-1 text-xs rounded-md bg-slate-800 border border-slate-700 font-mono">
                                            {{ $item->measurementUnit->mesureunitname ?? 'Kg' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($dyelote && $dyelote->duedate)
                                            <span class="font-mono text-xs {{ \Carbon\Carbon::parse($dyelote->duedate)->isPast() ? 'text-red-400 font-bold' : 'text-slate-300' }}">
                                                {{ \Carbon\Carbon::parse($dyelote->duedate)->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-slate-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-white text-base">
                                        {{ number_format($item->currentstock, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->currentstock <= $item->minstock)
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-500/10 text-red-400 border border-red-500/20">
                                                Stock Bajo
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                                Ok
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                                        No hay insumos registrados en la base de datos.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>