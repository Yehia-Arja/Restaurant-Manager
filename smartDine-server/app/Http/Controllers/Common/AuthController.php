<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\LoginRequest;
use App\Http\Requests\Common\SignupRequest;
use App\Services\Common\AuthService;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        try {
            $credentials = $request->validated();
            $userData = AuthService::login($credentials);

            if (!$userData) {
                return $this->error('Invalid credentials', 401);
            }
            
            return $this->success('Login successful', $userData);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function signup(SignupRequest $request) {
        try {
            $data = $request->validated();
            $userData = AuthService::signup($data);

            if (!$userData) {
                return $this->error('Signup failed');
            }

            return $this->success('Signup successful', $userData);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
