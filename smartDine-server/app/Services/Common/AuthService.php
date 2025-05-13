<?php

namespace App\Services\Common;

use App\Models\User;
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
            'user' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'user_type_id' => $user->user_type_id,
            ],
            'access_token' => $token,
        ];
    }

    public static function signup(array $data)
    {
        // Normalize email
        $data['email'] = strtolower($data['email']);


        // Create user
        User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // Log them in immediately
        $userData = self::login([
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        return $userData;
    }
}
