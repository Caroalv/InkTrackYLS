<x-app-layout>
    <div class="py-8 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Botón Volver y Título -->
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('items.index') }}" class="inline-flex items-center text-xs font-semibold text-indigo-400 hover:text-indigo-300 mb-2">
                        <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Volver a Insumos
                    </a>
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-bold text-white tracking-tight">{{ $item->itemname }}</h2>
                        <span class="px-2.5 py-1 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-lg font-mono text-xs font-bold">
                            {{ $item->phcode ?? 'Sin Código' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Ficha técnica y estado del inventario de este insumo</p>
                </div>
            </div>

            <!-- Métricas e Información de Stock -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-xl">
                    <span class="text-xs font-medium text-slate-400 uppercase">Stock Actual</span>
                    <div class="text-2xl font-bold text-emerald-400 mt-2">
                        {{ $item->currentstock ?? 0 }} <span class="text-sm text-slate-400 font-normal">{{ $item->measurementUnit->unitname ?? '' }}</span>
                    </div>
                </div>

                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-xl">
                    <span class="text-xs font-medium text-slate-400 uppercase">Stock Mínimo</span>
                    <div class="text-2xl font-bold text-slate-200 mt-2 font-mono">
                        {{ $item->minstock ?? 0 }}
                    </div>
                </div>

                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-xl">
                    <span class="text-xs font-medium text-slate-400 uppercase">Stock Máximo</span>
                    <div class="text-2xl font-bold text-slate-200 mt-2 font-mono">
                        {{ $item->maxstock ?? 0 }}
                    </div>
                </div>

                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-xl">
                    <span class="text-xs font-medium text-slate-400 uppercase">Peso Unitario Estimado</span>
                    <div class="text-2xl font-bold text-indigo-400 mt-2 font-mono">
                        {{ $item->estimatedunitweight ?? '-' }} <span class="text-xs text-slate-400 font-normal">Kg/L</span>
                    </div>
                </div>
            </div>

            <!-- Ficha Detallada -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-2xl space-y-6">
                <div class="border-b border-slate-800 pb-4">
                    <h3 class="text-base font-bold text-indigo-400">Clasificación</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800/80">
                        <span class="block text-slate-500 text-xs font-medium uppercase mb-1">Subgrupo</span>
                        <span class="text-sm font-semibold text-white">{{ $item->subgroup->subgroupname ?? 'No asignado' }}</span>
                    </div>

                    <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800/80">
                        <span class="block text-slate-500 text-xs font-medium uppercase mb-1">Grupo General</span>
                        <span class="text-sm font-semibold text-slate-200">{{ $item->subgroup->group->groupname ?? 'No asignado' }}</span>
                    </div>

                    <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800/80">
                        <span class="block text-slate-500 text-xs font-medium uppercase mb-1">Unidad de Medida</span>
                        <span class="text-sm font-semibold text-slate-200">{{ $item->measurementUnit->unitname ?? 'No asignada' }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>