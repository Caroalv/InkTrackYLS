<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Registrar Nueva Tinta / Insumo') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 p-8 rounded-2xl border border-slate-800 shadow-2xl space-y-6">
                
                <form action="{{ route('items.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Código PH -->
                        <div>
                            <label class="block text-slate-300 font-medium text-sm mb-1">Código PH</label>
                            <input type="text" name="phcode" value="{{ old('phcode') }}" 
                                   class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   placeholder="Ej: PH-004">
                        </div>

                        <!-- Nombre de la Tinta / Insumo -->
                        <div>
                            <label class="block text-slate-300 font-medium text-sm mb-1">Nombre del Insumo *</label>
                            <input type="text" name="itemname" value="{{ old('itemname') }}" required 
                                   class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   placeholder="Ej: Taurus Red Bright">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Subgrupo -->
                        <div>
                            <label class="block text-slate-300 font-medium text-sm mb-1">Subgrupo / Categoría *</label>
                            <select name="subgroupid" required class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Seleccionar --</option>
                                @foreach($subgroups as $subgroup)
                                    <option value="{{ $subgroup->id }}">{{ $subgroup->group->groupname ?? '' }} - {{ $subgroup->subgroupname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Unidad de Medida -->
                        <div>
                            <label class="block text-slate-300 font-medium text-sm mb-1">Unidad de Medida *</label>
                            <select name="muid" required class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Seleccionar --</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->mesureunitname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Stock Mínimo -->
                        <div>
                            <label class="block text-slate-300 font-medium text-sm mb-1">Stock Mínimo *</label>
                            <input type="number" step="0.01" name="minstock" value="{{ old('minstock', 2) }}" required 
                                   class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-4 py-2.5 text-sm focus:border-indigo-500">
                        </div>

                        <!-- Stock Máximo -->
                        <div>
                            <label class="block text-slate-300 font-medium text-sm mb-1">Stock Máximo *</label>
                            <input type="number" step="0.01" name="maxstock" value="{{ old('maxstock', 20) }}" required 
                                   class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-4 py-2.5 text-sm focus:border-indigo-500">
                        </div>

                        <!-- Peso Estimado -->
                        <div>
                            <label class="block text-slate-300 font-medium text-sm mb-1">Peso Estimado Unid.</label>
                            <input type="number" step="0.01" name="estimatedunitweight" value="{{ old('estimatedunitweight', 1) }}" 
                                   class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-4 py-2.5 text-sm focus:border-indigo-500">
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-800">
                        <a href="{{ route('items.index') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-sm font-semibold transition">
                            Cancelar
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold transition shadow-lg shadow-indigo-600/30">
                            Guardar Tinta
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>