<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExceptionController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

// Public Routes (Unified Landing Page & Tracking)
Route::get('/', [TrackingController::class, 'publicTrack'])->name('home');

Route::get('/track/{tracking_number?}', [TrackingController::class, 'publicTrack'])
    ->middleware('throttle:60,1')
    ->name('track.public');

// Language Switcher (ID & EN)
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'webLogin'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'webRegister'])->name('register.post');
Route::post('/logout', [AuthController::class, 'webLogout'])->name('logout');

// Authenticated Application Routes
Route::middleware('auth')->group(function () {
    // Dashboard & Notifications
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/notifications/mark-read', [DashboardController::class, 'markAllNotificationsRead'])->name('notifications.markRead');
    Route::get('/commodities', [DashboardController::class, 'commodities'])->name('commodities.index');

    // Shipments
    Route::get('/shipments', [ShipmentController::class, 'index'])->name('shipments.index');
    Route::get('/shipments/create', [ShipmentController::class, 'create'])->name('shipments.create');
    Route::post('/shipments', [ShipmentController::class, 'store'])->name('shipments.store');
    Route::get('/shipments/{id}', [ShipmentController::class, 'show'])->name('shipments.show');
    Route::get('/shipments/{id}/print', [ShipmentController::class, 'printWaybill'])->name('shipments.print');
    Route::post('/shipments/{id}/status', [ShipmentController::class, 'updateStatus'])->name('shipments.status');

    // Checkpoint Tracking Events
    Route::post('/shipments/{id}/events', [TrackingController::class, 'storeEvent'])->name('shipments.events.store');

    // Exceptions
    Route::post('/shipments/{id}/exceptions', [ExceptionController::class, 'store'])->name('shipments.exceptions.store');
    Route::post('/exceptions/{id}/resolve', [ExceptionController::class, 'resolve'])->name('exceptions.resolve');
});
