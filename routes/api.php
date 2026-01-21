<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\OrderController;

/*
|-----------------
| API Version 1
|-----------------
*/
Route::prefix('v1')->group(function () {
    // Login
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        // User
        Route::get('/user', fn (Request $request) => $request->user());

        // Orders
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus']);
        Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel']);

        // Logout
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});