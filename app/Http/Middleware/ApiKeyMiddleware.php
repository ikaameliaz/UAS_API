<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Mahasiswa;

class ApiKeyMahasiswa
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey || !Mahasiswa::where('api_key', $apiKey)->exists()) {
            return response()->json(['message' => 'Unauthorized: Invalid API Key'], 401);
        }

        return $next($request);
    }
}
