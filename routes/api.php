<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExceptionController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

// Public API endpoints with Rate Limiting (Throttle)
Route::middleware('throttle:30,1')->group(function () {
    Route::post('/login', [AuthController::class, 'apiLogin']);
    Route::get('/track/{tracking_number}', [TrackingController::class, 'publicTrack']);
    Route::get('/weather', [WeatherController::class, 'query']);
});

// Protected API endpoints (Laravel Sanctum Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'apiMe']);
    Route::post('/logout', [AuthController::class, 'apiLogout']);

    // Shipments API
    Route::get('/shipments', [ShipmentController::class, 'index']);
    Route::post('/shipments', [ShipmentController::class, 'store']);
    Route::get('/shipments/{id}', [ShipmentController::class, 'show']);
    Route::post('/shipments/{id}/status', [ShipmentController::class, 'updateStatus']);

    // Tracking Milestones
    Route::post('/shipments/{id}/events', [TrackingController::class, 'storeEvent']);

    // Exceptions & Delays
    Route::post('/shipments/{id}/exceptions', [ExceptionController::class, 'store']);
    Route::post('/exceptions/{id}/resolve', [ExceptionController::class, 'resolve']);
});
