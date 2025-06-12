<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // JWT methods
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Biasanya 'id'
    }

    public function getJWTCustomClaims()
    {
        return []; // Bisa custom misal ['role' => 'admin']
    }
}
