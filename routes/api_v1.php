<?php

use App\Http\Controllers\Api\UsuarioController;
use Illuminate\Support\Facades\Route;



Route::apiResource('usuarios', UsuarioController::class);