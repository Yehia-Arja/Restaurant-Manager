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
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'user_type_id' => $user->user_type_id,
                'restaurant_id' => $user->restaurant_id,
                'restaurant_location_id' => $user->restaurant_location_id,
                'phone_number' => $user->phone_number,
                'date_of_birth' => $user->date_of_birth,
                'google_id' => $user->google_id,
                'provider' => $user->provider,
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
        $userData = self::login([
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        return $userData;
    }
}
