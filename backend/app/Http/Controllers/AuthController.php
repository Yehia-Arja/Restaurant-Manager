<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $credentials = $request->validated();
        $data = LoginService::login($credentials);
        
        if (!$data) {
            return $this->error('Invalid credentials', 401);
        }
        return $this->success($data, 'Login successful');
    }
}
