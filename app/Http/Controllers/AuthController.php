<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Mahasiswa;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // 🚀 REGISTER ADMIN
    public function registerAdmin(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|min:6'
        ]);

        $admin = Admin::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Admin berhasil didaftarkan',
            'data'    => $admin
        ], 201);
    }

    // 🎓 REGISTER MAHASISWA
    public function registerMahasiswa(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'nim'      => 'required|unique:mahasiswa,nim',
            'jurusan'  => 'required|string|max:100',
            'email'    => 'required|email|unique:mahasiswa,email',
            'password' => 'required|min:6'
        ]);

        $mahasiswa = Mahasiswa::create([
            'nama'     => $request->nama,
            'nim'      => $request->nim,
            'jurusan'  => $request->jurusan,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Mahasiswa berhasil didaftarkan',
            'data'    => $mahasiswa
        ], 201);
    }

    // 🔐 LOGIN MULTI-GUARD
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'tipe'     => 'required|in:admin,mahasiswa',
        ]);

        $credentials = $request->only('email', 'password');
        $guard = $request->tipe;

        try {
            if (!$token = Auth::guard($guard)->attempt($credentials)) {
                return response()->json(['message' => 'Login gagal, cek email/password'], 401);
            }

            return response()->json([
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
                'user'         => Auth::guard($guard)->user(),
                'role'         => $guard
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat login',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // 🚪 LOGOUT
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Berhasil logout']);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Logout gagal'], 500);
        }
    }

    // 👀 ME (GET CURRENT USER SESUAI GUARD)
    public function me(Request $request)
{
    $guards = ['admin', 'mahasiswa'];

    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            return response()->json([
                'user' => Auth::guard($guard)->user(),
                'role' => $guard
            ]);
        }
    }

    return response()->json(['message' => 'Unauthenticated'], 401);
}
}
