<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

// --- RUTAS DE PRODUCTOS ---

// Listado y detalle de productos (Públicas)
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);

// Creación, actualización y eliminación (Protegidas)
Route::middleware('auth:api')->group(function () {
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{product}', [ProductController::class, 'update']);
    Route::delete('products/{product}', [ProductController::class, 'destroy']);
});
