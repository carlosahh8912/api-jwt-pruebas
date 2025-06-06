<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::any('test', function (Request $request) {

    $cookie = cookie('myTokenName', '12345678910', 1000 * 60 * 60 * 24 * 30, '/');

    // $serialize = serialize($cookie);

    $date = new DateTimeImmutable();

    return response()->json([
        'headers' => $request->header(),
        'data' => $request->all(),
        'timestamp' => $date->getTimestamp(),
        'fecha' => date('Y-m-d H:i', $date->getTimestamp()),
    ]);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api_v1.php';
