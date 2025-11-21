<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    public function register($data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);
    }

    public function attemptLogin($credentials)
    {
        if (!$token = auth()->attempt($credentials)) {
            return;
        }

        return $token;
    }
}
