<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\json;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!$token = Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(['email' =>  __('auth.failed')], 401);
        }

        return $this->respondWithToken($token);
    }

    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    public function update()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    public function destroy()
    {
        Auth::guard('api')->logout();

        return response()->noContent();
    }

    protected function respondWithToken($token)
    {
        $expire =  Auth::factory()->getTTL() * 60;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expire
        ])->header('Set-Cookie', cookie('auth-token', $token, $expire, '/'));
    }
}
