<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MovDetail;
use Illuminate\Http\Request;

class KardexController extends Controller
{
    public function index(Request $request)
    {
        $itemId = $request->get('item_id');
        $items = Item::orderBy('itemname', 'asc')->get();
        $movements = collect();
        $selectedItem = null;

        if ($itemId) {
            $selectedItem = Item::findOrFail($itemId);
            
            $movements = MovDetail::with(['header.docType', 'header.supplier'])
                ->where('itemid', $itemId)
                ->whereHas('header')
                ->get()
                ->sortBy(function ($detail) {
                    return $detail->header->docdate . ' ' . $detail->header->created_at;
                });
        }

        return view('kardex.index', compact('items', 'movements', 'selectedItem', 'itemId'));
    }
}