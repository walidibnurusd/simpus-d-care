<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // API key yang diharapkan
        $apiKey = config('services.api_key'); // Simpan API key di config/services.php
        
        // Cek apakah API key ada di header dan sesuai dengan yang diharapkan
        if ($request->header('api-key') !== $apiKey) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
