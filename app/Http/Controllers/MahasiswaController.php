<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::with('user')->get();
        return response()->json($mahasiswa);
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::with('user')->find($id);
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa not found'], 404);
        }
        return response()->json($mahasiswa);
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa not found'], 404);
        }
        $mahasiswa->update($request->only(['nim', 'jurusan']));
        return response()->json(['message' => 'Mahasiswa updated successfully', 'data' => $mahasiswa]);
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa not found'], 404);
        }
        $mahasiswa->delete();
        return response()->json(['message' => 'Mahasiswa deleted successfully']);
    }
}
