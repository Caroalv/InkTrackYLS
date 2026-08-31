<?php

use App\Http\Controllers\ProfileController;
use App\Models\Item;
use Illuminate\Support\Facades\Route;

// Redirigir la raíz directamente al Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Ruta del Dashboard con consulta a la base de datos
Route::get('/dashboard', function () {
    $items = Item::with(['subgroup.group', 'measurementUnit', 'dyelotes'])->get();
    
    return view('dashboard', compact('items'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de Perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';