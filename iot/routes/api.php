<?php

use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    # Login
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        # Auth options
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        # Users
        Route::post('/users', [UserController::class, 'store']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        # Devices
        Route::post('/devices', [DeviceController::class, 'store']);
        Route::delete('/devices/{id}', [DeviceController::class, 'destroy']);
        Route::post('/users/{user}/devices/{device}/attach', [DeviceController::class, 'attachDevice']);
        Route::delete('/users/{user}/devices/{device}/detach', [DeviceController::class, 'detachDevice']);

        # Measurements
        Route::post('/devices/{device}/measurements', [MeasurementController::class, 'store']);
    });
});
