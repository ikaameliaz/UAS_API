<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Cek role berdasarkan model yang digunakan (Admin atau Mahasiswa)
        if ($role === 'admin' && !$user instanceof \App\Models\Admin) {
            return response()->json(['message' => 'Access denied. Admin only.'], 403);
        }

        if ($role === 'mahasiswa' && !$user instanceof \App\Models\Mahasiswa) {
            return response()->json(['message' => 'Access denied. Mahasiswa only.'], 403);
        }

        return $next($request);
    }
}