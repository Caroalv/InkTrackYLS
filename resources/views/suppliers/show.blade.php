<x-app-layout>
    <div class="py-8 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Botón Volver y Título -->
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('suppliers.index') }}" class="inline-flex items-center text-xs font-semibold text-indigo-400 hover:text-indigo-300 mb-2">
                        <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Volver a Proveedores
                    </a>
                    <h2 class="text-2xl font-bold text-white tracking-tight">{{ $supplier->suppliername }}</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Ficha de información general del proveedor</p>
                </div>
            </div>

            <!-- Tarjeta Principal de Información -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-2xl space-y-6">
                <div class="border-b border-slate-800 pb-4">
                    <h3 class="text-base font-bold text-indigo-400">Datos de Contacto</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800/80">
                        <span class="block text-slate-500 text-xs font-medium uppercase mb-1">Contacto Principal</span>
                        <span class="text-sm font-semibold text-white">{{ $supplier->contactname ?? 'No registrado' }}</span>
                    </div>

                    <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800/80">
                        <span class="block text-slate-500 text-xs font-medium uppercase mb-1">Teléfono</span>
                        <span class="text-sm font-mono font-semibold text-indigo-300">{{ $supplier->phone ?? 'No registrado' }}</span>
                    </div>

                    <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800/80">
                        <span class="block text-slate-500 text-xs font-medium uppercase mb-1">Correo Electrónico</span>
                        <span class="text-sm font-semibold text-slate-200">{{ $supplier->email ?? 'No registrado' }}</span>
                    </div>

                    <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800/80">
                        <span class="block text-slate-500 text-xs font-medium uppercase mb-1">Fecha Registro</span>
                        <span class="text-sm font-semibold text-slate-300">{{ $supplier->created_at ? $supplier->created_at->format('d/m/Y H:i') : '-' }}</span>
                    </div>
                </div>

                <div class="bg-slate-950/50 p-4 rounded-xl border border-slate-800/80">
                    <span class="block text-slate-500 text-xs font-medium uppercase mb-1">Dirección Física</span>
                    <p class="text-sm text-slate-300">{{ $supplier->address ?? 'Sin dirección registrada.' }}</p>
                </div>
            </div>

            <!-- Sección de Historial / Relaciones (Opcional para cuando vincules Insumos o Compras) -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-2xl">
                <div class="border-b border-slate-800 pb-4 mb-4">
                    <h3 class="text-base font-bold text-white">Historial de Operaciones / Lotes</h3>
                    <p class="text-xs text-slate-400 mt-1">Registros asociados a este proveedor en el sistema.</p>
                </div>

                <div class="text-center py-8 text-slate-500 text-xs">
                    Próximamente se mostrarán las compras o lotes suministrados por este proveedor.
                </div>
            </div>

        </div>
    </div>
</x-app-layout>