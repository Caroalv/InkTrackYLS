<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Subgroup;
use App\Models\MeasurementUnit;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status'); // 'critical' o 'normal'

        // 1. Consulta base con relaciones
        $query = Item::with(['subgroup.group', 'measurementUnit']);

        // 2. Filtro por búsqueda de texto
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('itemname', 'like', "%{$search}%")
                  ->orWhere('phcode', 'like', "%{$search}%")
                  ->orWhereHas('subgroup', function($sub) use ($search) {
                      $sub->where('subgroupname', 'like', "%{$search}%");
                  });
            });
        }

        // 3. Filtro por estado de stock
        if ($status === 'critical') {
            $query->whereColumn('currentstock', '<=', 'minstock');
        } elseif ($status === 'normal') {
            $query->whereColumn('currentstock', '>', 'minstock');
        }

        // 4. Conteo general para las Cards/KPIs
        $totalItems = Item::count();
        $criticalCount = Item::whereColumn('currentstock', '<=', 'minstock')->count();
        $normalCount = Item::whereColumn('currentstock', '>', 'minstock')->count();

        // 5. Paginación
        $items = $query->latest()->paginate(10)->withQueryString();

        // 6. Carga de datos auxiliares para los modales
        $subgroups = Subgroup::with('group')->get();
        $measurementUnits = MeasurementUnit::all();

        return view('items.index', compact(
            'items', 
            'subgroups', 
            'measurementUnits', 
            'search', 
            'status', 
            'totalItems', 
            'criticalCount', 
            'normalCount'
        ));
    }

    public function create()
    {
        return redirect()->route('items.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phcode' => 'nullable|string|max:50',
            'itemname' => 'required|string|max:255',
            'subgroupid' => 'required|exists:subgroups,id',
            'muid' => 'required|exists:measurement_units,id',
            'minstock' => 'required|numeric|min:0',
            'maxstock' => 'required|numeric|min:0',
            'estimatedunitweight' => 'nullable|numeric|min:0',
        ]);

        $validated['currentstock'] = 0;

        Item::create($validated);

        return redirect()->route('items.index')->with('success', 'Insumo registrado correctamente.');
    }

    public function show(Item $item)
    {
        $item->load(['subgroup.group', 'measurementUnit']);

        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return redirect()->route('items.index');
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'phcode' => 'nullable|string|max:50',
            'itemname' => 'required|string|max:255',
            'subgroupid' => 'required|exists:subgroups,id',
            'muid' => 'required|exists:measurement_units,id',
            'minstock' => 'required|numeric|min:0',
            'maxstock' => 'required|numeric|min:0',
            'estimatedunitweight' => 'nullable|numeric|min:0',
        ]);

        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Insumo actualizado correctamente.');
    }

    public function destroy(Item $item)
    {
        try {
            $item->delete();
            return redirect()->route('items.index')->with('success', 'Insumo eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") { // Código SQLSTATE para restricción de FK
                return redirect()->route('items.index')->with('error', 'No se puede eliminar este insumo porque tiene registros o lotes asociados.');
            }
            return redirect()->route('items.index')->with('error', 'Ocurrió un error al intentar eliminar el insumo.');
        }
    }
}