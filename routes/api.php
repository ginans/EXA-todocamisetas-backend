<?php

use App\Http\Controllers\Api\CamisetaController;
use App\Http\Controllers\Api\ClienteController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::get('/camisetas', [CamisetaController::class, 'index']);
    Route::get('/camisetas/{id}', [CamisetaController::class, 'show'])->whereNumber('id');
    Route::post('/camisetas', [CamisetaController::class, 'store']);
    Route::put('/camisetas/{id}', [CamisetaController::class, 'update'])->whereNumber('id');
    Route::delete('/camisetas/{id}', [CamisetaController::class, 'destroy'])->whereNumber('id');

    Route::get('/clientes', [ClienteController::class, 'index']);
    Route::get('/clientes/{id}', [ClienteController::class, 'show'])->whereNumber('id');
    Route::post('/clientes', [ClienteController::class, 'store']);
    Route::put('/clientes/{id}', [ClienteController::class, 'update'])->whereNumber('id');
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->whereNumber('id');
});