<?php

use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('web')->group(function () {
    Route::get('/sessions', [ClientController::class, 'getSessions'])->name('api.sessions');
    Route::get('/getCart', [ClientController::class, 'getCart'])->name('api.getCart');
    Route::post('/addToCart', [ClientController::class, 'addToCart'])->name('api.addToCart');
    Route::post('/removeFromCart', [ClientController::class, 'removeFromCart'])->name('api.removeFromCart');
    Route::post('/clearCart', [ClientController::class, 'clearCart'])->name('api.clearCart');
    Route::post('/checkout', [ClientController::class, 'checkout'])->name('api.checkout');
    Route::post('/coolpay/webhook', [ClientController::class, 'handleCoolPayWebhook'])->name('api.coolpay.webhook');
});
