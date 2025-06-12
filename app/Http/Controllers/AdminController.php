<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // List semua admin
    public function index()
    {
        return response()->json(Admin::all());
    }

    // Tambah admin baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $admin = Admin::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['message' => 'Admin berhasil ditambahkan', 'admin' => $admin], 201);
    }

    // Detail admin
    public function show($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin tidak ditemukan'], 404);
        }

        return response()->json($admin);
    }

    // Update admin
    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['message' => 'Admin tidak ditemukan'], 404);
        }

        $admin->update([
            'nama' => $request->nama ?? $admin->nama,
            'email' => $request->email ?? $admin->email,
            'password' => $request->password ? Hash::make($request->password) : $admin->password
        ]);

        return response()->json(['message' => 'Admin diperbarui', 'admin' => $admin]);
    }

    // Hapus admin
    public function destroy($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['message' => 'Admin tidak ditemukan'], 404);
        }

        $admin->delete();
        return response()->json(['message' => 'Admin dihapus']);
    }
}