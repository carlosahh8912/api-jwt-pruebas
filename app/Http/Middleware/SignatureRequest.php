<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SignatureRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $signature = $request->header('Message-Signature');
        $timestamp = intval($request->header('Timestamp'));
        $secret = env('JWT_SECRET');

        $body = $request->all();

        try {

            if (!$timestamp) {
                throw new Exception("No se encuentra la fecha en la petición", 403);
            }

            if (is_string($timestamp)) {
                throw new Exception("La fecha tiene un formato incorrecto", 403);
            }

            if (date('Y-m-d H:i') !== date('Y-m-d H:i', $timestamp)) {
                throw new Exception("Fecha incorrecta en la petición", 403);
            }

            if (!$signature) {
                throw new Exception("El mensaje no esta firmado", 403);
            }

            if (!is_string($signature)) {
                throw new Exception("La firma tiene un formato incorrecto", 403);
            }

            $extendedHash = base64_encode(hash_hmac('sha256', json_encode($body), $secret, true));

            if ($extendedHash !== $signature) {
                throw new Exception("La firma es incorrecta", 403);
            }

            return $next($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
