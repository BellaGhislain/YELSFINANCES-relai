<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('web')->group(function () {
    // Home page
    Route::redirect('/', '/index');

    // Dashboard (authenticated users)

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // // User profile (authenticated users)
    // Route::view('profile', 'profile')
    //     ->middleware(['auth'])
    //     ->name('profile');

    // Administration routes
    Route::prefix('admin')->middleware(['auth'])->group(function () {
        //Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/session-stats', [AdminController::class, 'getSessionStats'])->name('admin.session-stats');

        // Formations
        Route::get('/formations', [AdminController::class, 'formations'])->name('admin.formations');
        Route::get('/formations/create', [AdminController::class, 'createFormation'])->name('admin.formations.create');
        Route::post('/formations', [AdminController::class, 'storeFormation'])->name('admin.formations.store');
        Route::get('/formations/{formation}/edit', [AdminController::class, 'editFormation'])->name('admin.formations.edit');
        Route::put('/formations/{formation}', [AdminController::class, 'updateFormation'])->name('admin.formations.update');
        Route::get('/formations/{formation}', [AdminController::class, 'showFormation'])->name('admin.formations.show');
        Route::post('/formations/{formation}/activate', [AdminController::class, 'activateFormation'])->name('admin.formations.activate');
        Route::post('/formations/{formation}/deactivate', [AdminController::class, 'deactivateFormation'])->name('admin.formations.deactivate');
        Route::post('/admin/formations/upload', [AdminController::class, 'uploadFile'])->name('admin.formations.upload');

        //Sessions
        Route::get('/sessions', [AdminController::class, 'sessions'])->name('admin.sessions.index');
        Route::get('/sessions/create', [AdminController::class, 'createSession'])->name('admin.sessions.create');
        Route::post('/sessions', [AdminController::class, 'storeSession'])->name('admin.sessions.store');
        Route::post('/sessions/{session}/deactivate', [AdminController::class, 'deactivateSession'])->name('admin.sessions.deactivate');
        Route::get('/sessions/{session}/edit', [AdminController::class, 'edit'])->name('admin.sessions.edit');
        Route::put('/sessions/{session}', [AdminController::class, 'update'])->name('admin.sessions.update');

        // Trainers
        Route::get('/trainers', [AdminController::class, 'trainers'])->name('admin.trainers');
        Route::get('/trainers/create', [AdminController::class, 'createTrainer'])->name('admin.trainers.create');
        Route::post('/trainers', [AdminController::class, 'storeTrainer'])->name('admin.trainers.store');
        Route::get('/trainers/{trainer}/edit', [AdminController::class, 'editTrainer'])->name('admin.trainers.edit');
        Route::put('/trainers/{trainer}', [AdminController::class, 'updateTrainer'])->name('admin.trainers.update');
        Route::get('/trainers/{trainer}', [AdminController::class, 'showTrainer'])->name('admin.trainers.show');
        Route::post('/trainers/{trainer}/deactivate', [AdminController::class, 'deactivateTrainer'])->name('admin.trainers.deactivate');

        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');

        // Payments
        Route::get('/payments', [AdminController::class, 'payments'])->name('admin.payments');
        Route::get('/payments/export', [AdminController::class, 'exportPayments'])->name('admin.payments.export');
        Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('admin.orders.show');

        // Attendees
        Route::get('/sessions/{session}/attendees', [AdminController::class, 'attendees'])->name('admin.sessions.attendees');
        Route::get('/sessions/{session}/attendees/export', [AdminController::class, 'exportAttendees'])->name('admin.sessions.attendees.export');
    });

    // Client routes

    Route::get('/index', [ClientController::class, 'index'])->name('client.index.alias');
    Route::get('/formation', [ClientController::class, 'formation'])->name('client.formation');
    Route::get('/a-propos', [ClientController::class, 'aPropos'])->name('client.a-propos');
    Route::get('/contact', [ClientController::class, 'contact'])->name('client.contact');
    Route::post('/order', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/order/confirmation/{order_id}', [OrderController::class, 'confirmation'])->name('order.confirmation');

    // Route::get('/admin/dashboard', function () {
    //     return view('admin.dashboard');
    // })->middleware(['auth'])->name('admin.dashboard');

    // Authentication routes
    require __DIR__ . '/auth.php';
});
