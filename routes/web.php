<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'version' => '1.0.0',
        'curren_api' => 'v1'
    ]);
});
