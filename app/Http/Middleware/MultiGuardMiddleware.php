<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MultiGuardMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $guards = ['admin', 'mahasiswa'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::shouldUse($guard); // set guard aktif
                return $next($request);
            }
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
