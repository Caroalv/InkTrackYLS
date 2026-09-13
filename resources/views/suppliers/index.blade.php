<x-app-layout>
    <div x-data="{ 
            showCreateModal: false, 
            showEditModal: false,
            editSupplier: { id: null, suppliername: '', contactname: '', phone: '', email: '', address: '' },
            openEditModal(supplier) {
                this.editSupplier = { ...supplier };
                this.showEditModal = true;
            }
         }" 
         class="py-8 bg-slate-950 min-h-screen text-slate-100">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Encabezado y Botón Crear -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Catálogo de Proveedores</h2>
                    <p class="text-xs text-slate-400 mt-1">Gestión y directorio de proveedores de insumos</p>
                </div>
                <button @click="showCreateModal = true" 
                        class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-medium text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition duration-200 group">
                    <svg class="w-4 h-4 me-2 group-hover:rotate-90 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Nuevo Proveedor</span>
                </button>
            </div>

            <!-- BUSCADOR -->
            <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 shadow-xl">
                <form method="GET" action="{{ route('suppliers.index') }}" class="flex gap-2">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ $search ?? '' }}" 
                               placeholder="Buscar por proveedor, contacto, teléfono o email..." 
                               class="w-full ps-10 bg-slate-950 border border-slate-800 text-white text-xs rounded-xl focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
                    </div>
                    
                    <button type="submit" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs rounded-xl transition">
                        Buscar
                    </button>

                    @if(!empty($search))
                        <a href="{{ route('suppliers.index') }}" class="px-4 py-2.5 bg-slate-800/50 hover:bg-slate-800 text-slate-400 font-semibold text-xs rounded-xl transition flex items-center">
                            Limpiar
                        </a>
                    @endif
                </form>
            </div>

            <!-- Tabla de Proveedores -->
            <div class="bg-slate-900 overflow-hidden shadow-2xl rounded-2xl border border-slate-800">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-300">
                        <thead class="text-xs text-slate-400 uppercase bg-slate-950/60 border-b border-slate-800">
                            <tr>
                                <th class="px-6 py-4">Proveedor</th>
                                <th class="px-6 py-4">Contacto</th>
                                <th class="px-6 py-4">Teléfono</th>
                                <th class="px-6 py-4">Correo</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($suppliers as $supplier)
                                <tr class="hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-white">{{ $supplier->suppliername }}</td>
                                    <td class="px-6 py-4 text-slate-300">{{ $supplier->contactname ?? '-' }}</td>
                                    <td class="px-6 py-4 font-mono text-xs text-slate-300">{{ $supplier->phone ?? '-' }}</td>
                                    <td class="px-6 py-4 text-xs text-slate-400">{{ $supplier->email ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <!-- Ver Detalle -->
                                        <a href="{{ route('suppliers.show', $supplier) }}" 
                                           class="text-emerald-400 hover:text-emerald-300 font-medium text-xs">
                                            Ver
                                        </a>

                                        <!-- Editar -->
                                        <button @click="openEditModal({{ json_encode($supplier) }})" 
                                                class="text-indigo-400 hover:text-indigo-300 font-medium text-xs">
                                            Editar
                                        </button>

                                        <!-- Eliminar -->
                                        <form id="delete-supplier-{{ $supplier->id }}" action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    onclick="confirmDelete('delete-supplier-{{ $supplier->id }}', '{{ addslashes($supplier->suppliername) }}')"
                                                    class="text-red-400 hover:text-red-300 font-medium text-xs">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                        @if(!empty($search))
                                            No se encontraron proveedores que coincidan con "{{ $search }}".
                                        @else
                                            No hay proveedores registrados.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($suppliers->hasPages())
                    <div class="p-4 border-t border-slate-800">
                        {{ $suppliers->links() }}
                    </div>
                @endif
            </div>

        </div>

        <!-- ================= MODAL CREAR PROVEEDOR ================= -->
        <div x-show="showCreateModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                
                <div x-show="showCreateModal" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     @click="showCreateModal = false" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity"></div>

                <div x-show="showCreateModal" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-slate-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-800">
                    
                    <div class="p-5">
                        <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-800">
                            <h3 class="text-base font-bold text-white">Nuevo Proveedor</h3>
                            <button @click="showCreateModal = false" class="text-slate-400 hover:text-slate-200 text-lg font-bold leading-none">&times;</button>
                        </div>

                        <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-3">
                            @csrf

                            <div>
                                <label class="block text-slate-300 font-medium text-xs mb-1">Nombre del Proveedor *</label>
                                <input type="text" name="suppliername" required placeholder="Ej. Distribuidora Química S.A."
                                       class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-slate-300 font-medium text-xs mb-1">Contacto Principal</label>
                                <input type="text" name="contactname" placeholder="Ej. Juan Pérez"
                                       class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Teléfono</label>
                                    <input type="text" name="phone" placeholder="Ej. 2222-2222"
                                           class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Correo Electrónico</label>
                                    <input type="email" name="email" placeholder="contacto@empresa.com"
                                           class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-slate-300 font-medium text-xs mb-1">Dirección</label>
                                <textarea name="address" rows="2" placeholder="Dirección del proveedor..."
                                          class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            </div>

                            <div class="flex items-center justify-end space-x-2 pt-4 border-t border-slate-800 mt-5">
                                <button type="button" @click="showCreateModal = false" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-semibold transition shadow-md shadow-indigo-600/30">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= MODAL EDITAR PROVEEDOR ================= -->
        <div x-show="showEditModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                
                <div x-show="showEditModal" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     @click="showEditModal = false" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity"></div>

                <div x-show="showEditModal" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-slate-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-800">
                    
                    <div class="p-5">
                        <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-800">
                            <h3 class="text-base font-bold text-white">Editar Proveedor</h3>
                            <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-200 text-lg font-bold leading-none">&times;</button>
                        </div>

                        <form :action="'/suppliers/' + editSupplier.id" method="POST" class="space-y-3">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-slate-300 font-medium text-xs mb-1">Nombre del Proveedor *</label>
                                <input type="text" name="suppliername" x-model="editSupplier.suppliername" required 
                                       class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label class="block text-slate-300 font-medium text-xs mb-1">Contacto Principal</label>
                                <input type="text" name="contactname" x-model="editSupplier.contactname" 
                                       class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Teléfono</label>
                                    <input type="text" name="phone" x-model="editSupplier.phone" 
                                           class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-slate-300 font-medium text-xs mb-1">Correo Electrónico</label>
                                    <input type="email" name="email" x-model="editSupplier.email" 
                                           class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-slate-300 font-medium text-xs mb-1">Dirección</label>
                                <textarea name="address" x-model="editSupplier.address" rows="2" 
                                          class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-3 py-2 text-xs focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            </div>

                            <div class="flex items-center justify-end space-x-2 pt-4 border-t border-slate-800 mt-5">
                                <button type="button" @click="showEditModal = false" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-semibold transition shadow-md shadow-indigo-600/30">
                                    Actualizar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>