<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExceptionController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return redirect()->route('track.public');
})->name('home');

Route::get('/track/{tracking_number?}', [TrackingController::class, 'publicTrack'])->name('track.public');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'webLogin'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'webRegister'])->name('register.post');
Route::post('/logout', [AuthController::class, 'webLogout'])->name('logout');

// Authenticated Application Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/commodities', [DashboardController::class, 'commodities'])->name('commodities.index');

    // Shipments
    Route::get('/shipments', [ShipmentController::class, 'index'])->name('shipments.index');
    Route::get('/shipments/create', [ShipmentController::class, 'create'])->name('shipments.create');
    Route::post('/shipments', [ShipmentController::class, 'store'])->name('shipments.store');
    Route::get('/shipments/{id}', [ShipmentController::class, 'show'])->name('shipments.show');
    Route::post('/shipments/{id}/status', [ShipmentController::class, 'updateStatus'])->name('shipments.status');

    // Checkpoint Tracking Events
    Route::post('/shipments/{id}/events', [TrackingController::class, 'storeEvent'])->name('shipments.events.store');

    // Exceptions
    Route::post('/shipments/{id}/exceptions', [ExceptionController::class, 'store'])->name('shipments.exceptions.store');
    Route::post('/exceptions/{id}/resolve', [ExceptionController::class, 'resolve'])->name('exceptions.resolve');
});
