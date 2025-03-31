<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\KitchenApiController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('orders', [OrderApiController::class, 'index']);
Route::post('orders/send-to-kitchen/{id}', [OrderApiController::class, 'sendToKitchen']);

Route::get('kitchen/orders', [KitchenApiController::class, 'getOrders']);
Route::post('kitchen/orders/complete/{id}', [KitchenApiController::class, 'completeOrder']);
Route::delete('/orders/{id}', [OrderApiController::class, 'destroy']);
Route::post('/orders/update-status', [KitchenApiController::class, 'updatePendingOrders']);

