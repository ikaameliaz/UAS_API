<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $complaints = Complaint::with('mahasiswa', 'category')->get();
        } else {
            $complaints = Complaint::with('mahasiswa', 'category')
                ->where('mahasiswa_id', $user->id)
                ->get();
        }

        return response()->json($complaints);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $complaint = Complaint::create([
            'mahasiswa_id' => Auth::id(), // ganti dari user_id
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'description'  => $request->description,
            'status'       => 'pending',
        ]);

        return response()->json(['message' => 'Complaint submitted', 'data' => $complaint], 201);
    }

    public function show($id)
    {
        $complaint = Complaint::with('mahasiswa', 'category', 'comments.user')->find($id);

        if (!$complaint)
            return response()->json(['message' => 'Complaint not found'], 404);

        return response()->json($complaint);
    }

    public function update(Request $request, $id)
    {
        $complaint = Complaint::find($id);
        if (!$complaint)
            return response()->json(['message' => 'Complaint not found'], 404);

        // Admin boleh update status, mahasiswa hanya bisa update title dan description
        if (Auth::user()->role === 'admin') {
            $request->validate([
                'status' => 'required|in:pending,in_progress,resolved'
            ]);
            $complaint->status = $request->status;
        } else {
            $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'required|string',
            ]);
            $complaint->title       = $request->title;
            $complaint->description = $request->description;
        }

        $complaint->save();

        return response()->json(['message' => 'Complaint updated', 'data' => $complaint]);
    }

    public function destroy($id)
    {
        $complaint = Complaint::find($id);
        if (!$complaint)
            return response()->json(['message' => 'Complaint not found'], 404);

        $complaint->delete();

        return response()->json(['message' => 'Complaint deleted']);
    }
}
