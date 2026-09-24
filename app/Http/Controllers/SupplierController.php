<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Throwable;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $suppliers = Supplier::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('suppliername', 'like', "%{$search}%")
                        ->orWhere('contactname', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('suppliers.index', compact('suppliers', 'search'));
    }

    public function create()
    {
        return redirect()->route('suppliers.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'suppliername' => 'required|string|max:255',
            'contactname'  => 'nullable|string|max:255',
            'phone'        => 'nullable|string|max:50',
            'email'        => 'nullable|email|max:255',
            'address'      => 'nullable|string|max:500',
        ]);

        Supplier::create($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Proveedor registrado correctamente.');
    }

    public function show(Supplier $supplier)
    {
        $supplier->load([
            'movHeaders.docType',
            'movHeaders.dyelotes.item',
        ]);

        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return redirect()->route('suppliers.index');
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'suppliername' => 'required|string|max:255',
            'contactname'  => 'nullable|string|max:255',
            'phone'        => 'nullable|string|max:50',
            'email'        => 'nullable|email|max:255',
            'address'      => 'nullable|string|max:500',
        ]);

        $supplier->update($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();

            return redirect()
                ->route('suppliers.index')
                ->with('success', 'Proveedor eliminado correctamente.');

        } catch (Throwable $e) {

            if ($e->getCode() == "23000" || str_contains($e->getMessage(), '1451')) {
                return redirect()
                    ->route('suppliers.index')
                    ->with(
                        'error',
                        'No se puede eliminar este proveedor porque tiene registros o compras asociadas.'
                    );
            }

            return redirect()
                ->route('suppliers.index')
                ->with(
                    'error',
                    'Ocurrió un error al intentar eliminar el proveedor.'
                );
        }
    }
}