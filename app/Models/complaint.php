<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class complaint extends Model
{
    protected $table = 'complaints'; // Tambahin biar Laravel gak bingung
    protected $fillable = ['mahasiswa_id', 'category_id', 'title', 'description', 'status'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\category::class); // Kasih path lengkap biar gak error
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\comment::class); // Sama ini
    }
}
