<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMahasiswa
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('Authorization');

        // Format: "Bearer MAHASISWA123"
        if (!$apiKey || $apiKey !== 'Bearer dgBpx44uclMR1LVfch5OdTD2KKXASSyE1dZDcCW8php') {
            return response()->json(['message' => 'API Key tidak valid'], 401);
        }

        return $next($request);
    }
}
