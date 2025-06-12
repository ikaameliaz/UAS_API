<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $complaint_id)
    {
        $request->validate([
            'comment_text' => 'required|string',
        ]);

        $complaint = Complaint::find($complaint_id);
        if (!$complaint) {
            return response()->json(['message' => 'Complaint not found'], 404);
        }

        // ✅ Gunakan guard admin untuk mengecek otorisasi
        if (!Auth::guard('admin')->check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment = Comment::create([
            'complaint_id' => $complaint_id,
            'admin_id'     => Auth::guard('admin')->id(), // Sesuai dengan kolom di tabel comments
            'comment_text' => $request->comment_text,
        ]);

        return response()->json(['message' => 'Comment added', 'data' => $comment], 201);
    }

    public function index($complaint_id)
    {
        $comments = Comment::with('admin') // Pastikan relasi ini ada di model Comment
                           ->where('complaint_id', $complaint_id)
                           ->get();

        return response()->json($comments);
    }
}
