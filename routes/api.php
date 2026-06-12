<?php

use App\Http\Controllers\Api\CamisetaController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\TallaController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::get('/camisetas', [CamisetaController::class, 'index']);
    Route::get('/camisetas/{id}', [CamisetaController::class, 'show'])->whereNumber('id');
    Route::get('/camisetas/{id}/precio-final', [CamisetaController::class, 'precioFinal'])->whereNumber('id');
    Route::post('/camisetas', [CamisetaController::class, 'store']);
    Route::put('/camisetas/{id}', [CamisetaController::class, 'update'])->whereNumber('id');
    Route::delete('/camisetas/{id}', [CamisetaController::class, 'destroy'])->whereNumber('id');
    Route::get('/camisetas/{id}/tallas', [CamisetaController::class, 'tallas'])->whereNumber('id');
    Route::post('/camisetas/{id}/tallas', [CamisetaController::class, 'attachTalla'])->whereNumber('id');
    Route::delete('/camisetas/{id}/tallas/{tallaId}', [CamisetaController::class, 'detachTalla'])->whereNumber('id')->whereNumber('tallaId');

    Route::get('/clientes', [ClienteController::class, 'index']);
    Route::get('/clientes/{id}', [ClienteController::class, 'show'])->whereNumber('id');
    Route::get('/clientes/{id}/camisetas', [ClienteController::class, 'camisetas'])->whereNumber('id');
    Route::post('/clientes', [ClienteController::class, 'store']);
    Route::put('/clientes/{id}', [ClienteController::class, 'update'])->whereNumber('id');
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->whereNumber('id');

    Route::get('/tallas', [TallaController::class, 'index']);
    Route::get('/tallas/{id}', [TallaController::class, 'show'])->whereNumber('id');
    Route::post('/tallas', [TallaController::class, 'store']);
    Route::put('/tallas/{id}', [TallaController::class, 'update'])->whereNumber('id');
    Route::delete('/tallas/{id}', [TallaController::class, 'destroy'])->whereNumber('id');
});