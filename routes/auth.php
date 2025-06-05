<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'api'])->prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'store'])->withoutMiddleware('auth:api');
    Route::post('logout', [AuthController::class, 'destroy']);
    Route::post('refresh', [AuthController::class, 'update']);
    Route::get('user', [AuthController::class, 'show']);
});
