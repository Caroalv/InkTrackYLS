<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dyelote;
use Carbon\Carbon;

class BatchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $today = Carbon::today();
        $warningDate = Carbon::today()->addDays(30);

        /*
        |--------------------------------------------------------------------------
        | Conteos para las tarjetas superiores
        |--------------------------------------------------------------------------
        */

        // Lotes vencidos
        $expiredCount = Dyelote::whereNotNull('duedate')
            ->whereDate('duedate', '<', $today)
            ->count();

        // Lotes vigentes: más de 30 días para vencer
        $activeCount = Dyelote::whereNotNull('duedate')
            ->whereDate('duedate', '>', $warningDate)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Consulta principal
        |--------------------------------------------------------------------------
        */

        $query = Dyelote::with([
            'item.measurementUnit'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Búsqueda
        |--------------------------------------------------------------------------
        */

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('dyelote', 'like', "%{$search}%")
                    ->orWhereHas('item', function ($qItem) use ($search) {
                        $qItem->where('itemname', 'like', "%{$search}%");
                    });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filtro por estado
        |--------------------------------------------------------------------------
        */

        if ($status === 'expired') {

            // Fecha anterior a hoy
            $query->whereDate('duedate', '<', $today);

        } elseif ($status === 'expiring') {

            // Desde hoy hasta los próximos 30 días
            $query->whereDate('duedate', '>=', $today)
                ->whereDate('duedate', '<=', $warningDate);

        } elseif ($status === 'active') {

            // Más de 30 días para vencer
            $query->whereDate('duedate', '>', $warningDate);
        }

        /*
        |--------------------------------------------------------------------------
        | Paginación
        |--------------------------------------------------------------------------
        */

        $batches = $query
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('batches.index', compact(
            'batches',
            'search',
            'status',
            'activeCount',
            'expiredCount'
        ));
    }
}