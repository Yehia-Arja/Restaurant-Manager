<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $credentials = $request->validated();
        $userData = AuthService::login($credentials);
        
        if (!$userData) {
            return $this->error('Invalid credentials', 401);
        }
        return $this->success($userData, 'Login successful');
    }

    public function signup(LoginRequest $request) {
        $data = $request->validated();
        $userData = AuthService::signup($data);
        
        if (!$userData) {
            return $this->error('Signup failed');
        }
        return $this->success($userData, 'Signup successful');
    }
}
