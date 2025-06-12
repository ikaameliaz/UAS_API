<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'nama',
        'nim',
        'jurusan',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Tambahan untuk JWT
    public function getJWTIdentifier()
    {
        return $this->getKey(); // biasanya id
    }

    public function getJWTCustomClaims()
    {
        return []; // kalau kamu mau custom claims, bisa isi sini
    }
}
