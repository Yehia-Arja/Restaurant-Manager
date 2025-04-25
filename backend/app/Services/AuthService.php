<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public static function login(array $credentials)
    {
        // Try to authenticate user
        if (!$token = Auth::attempt($credentials)) {
            return null; // Authentication failed
        }

        // Get the authenticated user
        $user = Auth::user();

        // Return user + token
        return [
            'user' => $user,
            'access_token' => $token,
        ];
    }
}
