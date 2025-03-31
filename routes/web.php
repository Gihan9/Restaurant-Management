<?php
use App\Http\Controllers\ConcessionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('concessions.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::resource('concessions', ConcessionController::class);
Route::resource('orders', OrderController::class);

Route::get('kitchen', [KitchenController::class, 'index'])->name('kitchen.index');

Route::get('/api/check-order-status', [KitchenController::class, 'checkOrderStatus'])->name('orders.checkStatus');

require __DIR__.'/auth.php';
