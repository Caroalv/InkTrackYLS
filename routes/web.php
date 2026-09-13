<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MovementController;
use App\Models\Item;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\KardexController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        $items = Item::with(['subgroup.group', 'measurementUnit', 'dyelotes'])->get();
        return view('dashboard', compact('items'));
    })->name('dashboard');

    // CRUD de Tintas / Ítems
    Route::resource('items', ItemController::class);
    Route::resource('suppliers', SupplierController::class);

    // CRUD de Movimientos (Entradas / Salidas de Tintas)
    Route::get('/movements', [MovementController::class, 'index'])->name('movements.index');
    Route::get('/movements/create', [MovementController::class, 'create'])->name('movements.create');
    Route::post('/movements', [MovementController::class, 'store'])->name('movements.store');


    // CRUD de grupos

    Route::resource('groups', GroupController::class);

    // Rutas específicas para Subgrupos dentro del mismo controlador
    Route::post('/groups/subgroups/store', [GroupController::class, 'storeSubgroup'])->name('subgroups.store');
    Route::put('/groups/subgroups/{subgroup}', [GroupController::class, 'updateSubgroup'])->name('subgroups.update');
    Route::delete('/groups/subgroups/{subgroup}', [GroupController::class, 'destroySubgroup'])->name('subgroups.destroy');


    Route::get('/movements', [MovementController::class, 'index'])->name('movements.index');
    Route::post('/movements', [MovementController::class, 'store'])->name('movements.store');

    Route::get('/kardex', [KardexController::class, 'index'])->name('kardex.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';