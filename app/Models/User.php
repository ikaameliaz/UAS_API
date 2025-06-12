<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Mahasiswa;
use App\Models\Complaint;
use App\Models\Comment;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * Kolom yang boleh diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Kolom yang disembunyikan saat model diserialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi one-to-one dengan tabel mahasiswa.
     */
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    /**
     * Relasi one-to-many dengan tabel complaints.
     */
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    /**
     * Relasi one-to-many dengan tabel comments.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Mendapatkan identifier JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Mendapatkan custom claims untuk JWT.
     *
     * @return array<string, mixed>
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
