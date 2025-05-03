<?php

namespace App\Http\Controllers\Common;
use App\Http\Controllers\Controller;

use App\Http\Requests\Common\LoginRequest;
use App\Http\Requests\Common\SignupRequest;
use App\Services\Common\AuthService;


class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $credentials = $request->validated();
        $userData = AuthService::login($credentials);
        
        if (!$userData) {
            return $this->error('Invalid credentials', 401);
        }
        return $this->success('Login successful', $userData);
    }

    public function signup(SignupRequest $request) {
        $data = $request->validated();
        $userData = AuthService::signup($data);
        
        if (!$userData) {
            return $this->error('Signup failed');
        }
        return $this->success('Signup successful', $userData);
    }
}
