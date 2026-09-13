<x-app-layout>
    <div class="py-8 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">Registrar Nuevo Proveedor</h2>
                <p class="text-xs text-slate-400 mt-1">Completa los campos para agregar un proveedor al catálogo</p>
            </div>

            <div class="bg-slate-900 p-8 rounded-2xl border border-slate-800 shadow-2xl">
                <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-slate-300 font-medium text-sm mb-1">Nombre / Razon Social *</label>
                        <input type="text" name="suppliername" value="{{ old('suppliername') }}" required 
                               class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-slate-300 font-medium text-sm mb-1">Persona de Contacto</label>
                        <input type="text" name="contact" value="{{ old('contact') }}" 
                               class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-slate-300 font-medium text-sm mb-1">Teléfono</label>
                            <input type="text" name="phonenumber" value="{{ old('phonenumber') }}" 
                                   class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-slate-300 font-medium text-sm mb-1">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-800">
                        <a href="{{ route('suppliers.index') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-sm font-semibold transition">
                            Cancelar
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-indigo-600/30">
                            Guardar Proveedor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>