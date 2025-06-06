<?php

use App\Http\Controllers\Api\UsuarioController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::apiResource('usuarios', UsuarioController::class)->middlewareFor(['store', 'update', 'destroy'], 'messageSignature');
});
