<x-app-layout>
    <div class="py-8 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Botón Volver y Título -->
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('suppliers.index') }}"
                       class="inline-flex items-center text-xs font-semibold text-indigo-400 hover:text-indigo-300 mb-2">
                        <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 19l-7-7 7-7"/>
                        </svg>
                        Volver a Proveedores
                    </a>

                    <h2 class="text-2xl font-bold text-white tracking-tight">
                        {{ $supplier->suppliername }}
                    </h2>

                    <p class="text-xs text-slate-400 mt-0.5">
                        Ficha de información general del proveedor
                    </p>
                </div>
            </div>


            <!-- ========================================= -->
            <!-- INFORMACIÓN DEL PROVEEDOR -->
            <!-- ========================================= -->

            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-2xl space-y-6">

                <div class="border-b border-slate-800 pb-4">
                    <h3 class="text-base font-bold text-indigo-400">
                        Datos de Contacto
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Contacto -->
                    <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800/80">
                        <span class="block text-slate-500 text-xs font-medium uppercase mb-1">
                            Contacto Principal
                        </span>

                        <span class="text-sm font-semibold text-white">
                            {{ $supplier->contactname ?? 'No registrado' }}
                        </span>
                    </div>


                    <!-- Teléfono -->
                    <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800/80">
                        <span class="block text-slate-500 text-xs font-medium uppercase mb-1">
                            Teléfono
                        </span>

                        <span class="text-sm font-mono font-semibold text-indigo-300">
                            {{ $supplier->phone ?? 'No registrado' }}
                        </span>
                    </div>


                    <!-- Correo -->
                    <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800/80">
                        <span class="block text-slate-500 text-xs font-medium uppercase mb-1">
                            Correo Electrónico
                        </span>

                        <span class="text-sm font-semibold text-slate-200">
                            {{ $supplier->email ?? 'No registrado' }}
                        </span>
                    </div>


                    <!-- Fecha -->
                    <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800/80">
                        <span class="block text-slate-500 text-xs font-medium uppercase mb-1">
                            Fecha Registro
                        </span>

                        <span class="text-sm font-semibold text-slate-300">
                            {{ $supplier->created_at ? $supplier->created_at->format('d/m/Y H:i') : '-' }}
                        </span>
                    </div>

                </div>


                <!-- Dirección -->
                <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800/80">

                    <span class="block text-slate-500 text-xs font-medium uppercase mb-1">
                        Dirección Física
                    </span>

                    <p class="text-sm text-slate-300">
                        {{ $supplier->address ?? 'Sin dirección registrada.' }}
                    </p>

                </div>

            </div>


            <!-- ========================================= -->
            <!-- HISTORIAL DE OPERACIONES -->
            <!-- ========================================= -->

            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-2xl">

                <div class="border-b border-slate-800 pb-4 mb-6">

                    <h3 class="text-base font-bold text-white">
                        Historial de Operaciones / Lotes
                    </h3>

                    <p class="text-xs text-slate-400 mt-1">
                        Movimientos y lotes registrados por este proveedor.
                    </p>

                </div>


                @if($supplier->movHeaders->count() > 0)

                    <div class="space-y-6">

                        @foreach($supplier->movHeaders as $movement)

                            <div class="border border-slate-800 rounded-xl overflow-hidden">

                                <!-- Cabecera del movimiento -->
                                <div class="bg-slate-950/70 px-5 py-4">

                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                                        <div>

                                            <div class="flex items-center gap-3">

                                                <h4 class="text-sm font-bold text-white">
                                                    {{ $movement->docnumber }}
                                                </h4>

                                                @if($movement->docType)
                                                    <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-indigo-500/10 text-indigo-300 border border-indigo-500/20">
                                                        {{ $movement->docType->docname ?? 'Documento' }}
                                                    </span>
                                                @endif

                                            </div>

                                            <p class="text-xs text-slate-500 mt-1">
                                                Fecha:
                                                {{ $movement->docdate ? \Carbon\Carbon::parse($movement->docdate)->format('d/m/Y') : '-' }}
                                            </p>

                                        </div>

                                        <div class="text-xs text-slate-400">

                                            {{ $movement->dyelotes->count() }}
                                            {{ $movement->dyelotes->count() == 1 ? 'lote' : 'lotes' }}

                                        </div>

                                    </div>

                                </div>


                                <!-- Lotes -->
                                @if($movement->dyelotes->count() > 0)

                                    <div class="overflow-x-auto">

                                        <table class="min-w-full divide-y divide-slate-800">

                                            <thead class="bg-slate-950/40">

                                                <tr>

                                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                                        Lote
                                                    </th>

                                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                                        Insumo
                                                    </th>

                                                    <th class="px-5 py-3 text-center text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                                        Cantidad Inicial
                                                    </th>

                                                    <th class="px-5 py-3 text-center text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                                        Saldo
                                                    </th>

                                                    <th class="px-5 py-3 text-center text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                                        Vencimiento
                                                    </th>

                                                    <th class="px-5 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                                        MSDS
                                                    </th>

                                                </tr>

                                            </thead>


                                            <tbody class="divide-y divide-slate-800">

                                                @foreach($movement->dyelotes as $batch)

                                                    @php
                                                        $expDate = $batch->duedate
                                                            ? \Carbon\Carbon::parse($batch->duedate)
                                                            : null;

                                                        $daysLeft = $expDate
                                                            ? (int) now()->startOfDay()->diffInDays($expDate, false)
                                                            : null;
                                                    @endphp

                                                    <tr class="hover:bg-slate-800/30 transition">

                                                        <!-- Lote -->
                                                        <td class="px-5 py-4">

                                                            <span class="text-sm font-semibold text-indigo-300">
                                                                {{ $batch->dyelote }}
                                                            </span>

                                                        </td>


                                                        <!-- Insumo -->
                                                        <td class="px-5 py-4">

                                                            <div class="text-sm text-slate-200">
                                                                {{ $batch->item->itemname ?? 'Sin insumo' }}
                                                            </div>

                                                        </td>


                                                        <!-- Cantidad -->
                                                        <td class="px-5 py-4 text-center">

                                                            <span class="text-sm font-semibold text-slate-200">
                                                                {{ $batch->qtyxlote ?? 0 }}
                                                            </span>

                                                        </td>


                                                        <!-- Saldo -->
                                                        <td class="px-5 py-4 text-center">

                                                            <span class="text-sm font-semibold text-slate-200">
                                                                {{ $batch->qtybalance ?? 0 }}
                                                            </span>

                                                        </td>


                                                        <!-- Vencimiento -->
                                                        <td class="px-5 py-4 text-center">

                                                            @if($expDate)

                                                                @if($daysLeft < 0)

                                                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-rose-500/10 text-rose-300 border border-rose-500/20">
                                                                        {{ $expDate->format('d/m/Y') }}
                                                                        · Vencido
                                                                    </span>

                                                                @elseif($daysLeft <= 30)

                                                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-amber-500/10 text-amber-300 border border-amber-500/20">
                                                                        {{ $expDate->format('d/m/Y') }}
                                                                        · Próximo
                                                                    </span>

                                                                @else

                                                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-emerald-500/10 text-emerald-300 border border-emerald-500/20">
                                                                        {{ $expDate->format('d/m/Y') }}
                                                                        · Vigente
                                                                    </span>

                                                                @endif

                                                            @else

                                                                <span class="text-xs text-slate-500">
                                                                    Sin fecha
                                                                </span>

                                                            @endif

                                                        </td>


                                                        <!-- MSDS -->
                                                        <td class="px-5 py-4">

                                                            <span class="text-xs font-mono text-slate-400">
                                                                {{ $batch->MSDS ?? 'No registrado' }}
                                                            </span>

                                                        </td>

                                                    </tr>

                                                @endforeach

                                            </tbody>

                                        </table>

                                    </div>

                                @else

                                    <div class="px-5 py-8 text-center text-xs text-slate-500">
                                        Este movimiento no tiene lotes asociados.
                                    </div>

                                @endif

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="text-center py-10">

                        <div class="text-slate-600 mb-2">
                            <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.5L19 9.5V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>

                        <p class="text-sm text-slate-400">
                            Este proveedor todavía no tiene operaciones registradas.
                        </p>

                    </div>

                @endif

            </div>

        </div>
    </div>
</x-app-layout>