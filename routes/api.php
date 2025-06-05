<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('test', function(Request $request){

    $cookie = cookie('myTokenName', '12345678910', 1000*60*60*24*30,'/');

    // $serialize = serialize($cookie);

    return response()->json([
        'headers' => $request->header(),
        'data' => $request->all(),
    ])->header('Set-Cookie', $cookie);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api_v1.php';