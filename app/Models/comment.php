<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'admin_id',
        'comment_text',
    ];

    /**
     * Relasi ke pengaduan (complaint)
     */
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    /**
     * Relasi ke admin (yang membuat komentar)
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
