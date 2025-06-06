<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::any('test', function (Request $request) {

    $cookie = cookie('myTokenName', '12345678910', 1000 * 60 * 60 * 24 * 30, '/');

    // $serialize = serialize($cookie);

    $longString = $request->header('Client-Request-Id') . $request->header('Timestamp') . json_encode($request->all());

    $date = new DateTimeImmutable();

    return response()->json([
        'headers' => $request->header(),
        'data' => $request->all(),
        'timestamp' => $date->getTimestamp(),
        'fecha' => date('Y-m-d H:i:s', intval($request->header('Timestamp'))),
        'firma' =>  base64_encode(hash_hmac('sha256', $longString, env('JWT_SECRET'), true)),
    ]);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api_v1.php';
