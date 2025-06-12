<?php

return [

    'defaults' => [
        'guard' => 'mahasiswa', // default guard: mahasiswa
        'passwords' => 'mahasiswas',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],

        // Guard JWT untuk Admin
        'admin' => [
            'driver' => 'jwt',
            'provider' => 'admins',
        ],

        // Guard Basic Auth untuk Admin
        'admin_basic' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        // Guard JWT untuk Mahasiswa
        'mahasiswa' => [
            'driver' => 'jwt',
            'provider' => 'mahasiswas',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'mahasiswas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Mahasiswa::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'mahasiswas' => [
            'provider' => 'mahasiswas',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
