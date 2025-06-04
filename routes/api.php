<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('test', function(Request $request){
    return response()->json([
        'headers' => $request->header(),
        'data' => $request->all(),
    ]);
});

require __DIR__ . '/api_v1.php';
