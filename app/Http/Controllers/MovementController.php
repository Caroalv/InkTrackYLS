<?php

namespace App\Http\Controllers;

use App\Models\MovHeader;
use App\Models\MovDetail;
use App\Models\Dyelote;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\DocType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class MovementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $movements = MovHeader::with(['supplier', 'docType', 'details.item'])
            ->when($search, function ($query, $search) {
                return $query->where('docnumber', 'like', "%{$search}%")
                    ->orWhereHas('supplier', function ($q) use ($search) {
                        $q->where('suppliername', 'like', "%{$search}%");
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $items = Item::orderBy('itemname', 'asc')->get();
        $suppliers = Supplier::orderBy('suppliername', 'asc')->get();
        $docTypes = DocType::all();

        return view('movements.index', compact('movements', 'items', 'suppliers', 'docTypes', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'movtype'     => 'required|in:IN,OUT',
            'docdate'     => 'required|date',
            'docnumber'   => 'required|string|max:50',
            'doctypeid'   => 'required|exists:doc_types,id',
            'supplierid'  => 'nullable|exists:suppliers,id',
            'items'       => 'required|array|min:1',
            'items.*.id'  => 'required|exists:items,id',
            'items.*.qty' => 'required|numeric|min:0.01',
            'items.*.batch_number'    => 'nullable|required_if:movtype,IN|string|max:255',
            'items.*.expiration_date' => 'nullable|required_if:movtype,IN|date',
        ], [
            'docnumber.required' => 'El número de documento es obligatorio.',
            'items.required'     => 'Debe incluir al menos un insumo en el movimiento.',
            'items.*.qty.min'    => 'La cantidad debe ser mayor a 0.',
            'items.*.batch_number.required_if' => 'El lote MSDS es obligatorio para las entradas.',
            'items.*.expiration_date.required_if' => 'La fecha de vencimiento es obligatoria para las entradas.',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Crear el Encabezado
                $header = MovHeader::create([
                    'doctypeid'  => $request->doctypeid,
                    'supplierid' => $request->supplierid,
                    'docnumber'  => $request->docnumber,
                    'docdate'    => $request->docdate,
                    'YLSindate'  => $request->movtype === 'IN' ? now() : null,
                    'SPindate'   => $request->movtype === 'OUT' ? now() : null,
                ]);

                // 2. Procesar Detalles, Stock y Guardado en Dyelote
                foreach ($request->items as $row) {
                    $item = Item::findOrFail($row['id']);

                    if ($request->movtype === 'OUT') {
                        if ($item->currentstock < $row['qty']) {
                            throw new \Exception("Stock insuficiente para '{$item->itemname}'. Stock actual: {$item->currentstock}");
                        }
                        $item->decrement('currentstock', $row['qty']);
                    } else {
                        $item->increment('currentstock', $row['qty']);
                    }

                    // Detalle del movimiento
                    $movDetail = MovDetail::create([
                        'headerid'        => $header->id,
                        'itemid'          => $item->id,
                        'qty'             => $row['qty'],
                        'realweight'      => $row['realweight'] ?? null,
                        'batch_number'    => $request->movtype === 'IN' ? ($row['batch_number'] ?? null) : null,
                        'expiration_date' => $request->movtype === 'IN' ? ($row['expiration_date'] ?? null) : null,
                    ]);

                    // Inserta automáticamente en Dyelotes si es entrada con lote
                    if ($request->movtype === 'IN' && !empty($row['batch_number'])) {
                        Dyelote::create([
                            'movdetailsid_IN' => $movDetail->id,
                            'itemid'          => $item->id,
                            'dyelote'         => $row['batch_number'],
                            'duedate'         => $row['expiration_date'] ?? null,
                            'qtyxlote'        => $row['qty'],
                            'qtybalance'      => $row['qty'],
                        ]);
                    }
                }
            });

            return redirect()->route('movements.index')->with('success', 'Movimiento registrado correctamente.');

        } catch (\Exception $e) {
            return redirect()->route('movements.index')->with('error', $e->getMessage());
        } catch (QueryException $e) {
            return redirect()->route('movements.index')->with('error', 'Ocurrió un error en la base de datos al guardar el movimiento.');
        }
    }

    public function show($id)
    {
        $movement = MovHeader::with(['supplier', 'docType', 'details.item'])->findOrFail($id);

        return response()->json([
            'id'        => $movement->id,
            'docdate'   => $movement->docdate,
            'docnumber' => $movement->docnumber,
            'doctype'   => $movement->docType->doctypename ?? 'N/A',
            'supplier'  => $movement->supplier->suppliername ?? 'N/A',
            'type'      => $movement->YLSindate ? 'ENTRADA' : 'SALIDA',
            'details'   => $movement->details->map(function ($detail) {
                return [
                    'item'            => $detail->item->itemname ?? 'Insumo Eliminado',
                    'qty'             => $detail->qty,
                    'realweight'      => $detail->realweight ?? 'N/A',
                    'batch_number'    => $detail->batch_number ?? 'N/A',
                    'expiration_date' => $detail->expiration_date ?? 'N/A',
                ];
            }),
        ]);
    }
}