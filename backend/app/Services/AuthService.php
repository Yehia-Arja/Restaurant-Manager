<?php

namespace App\Services;

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
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
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
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // Log them in immediately
        $data = self::login([
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        return $data;
    }
}
