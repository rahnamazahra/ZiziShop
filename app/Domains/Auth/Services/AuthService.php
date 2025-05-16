<?php

namespace App\Domains\Auth\Services;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserMinimalResource;

class AuthService
{
    public function login(string $mobile, string $password): array
    {
        $credentials = ['mobile' => $mobile, 'password' => $password];
        $token = Auth::attempt($credentials);

        if (!$token) {
            return ['success' => false];
        }

        return [
            'success' => true,
            'token' => $token,
            'user' => new UserMinimalResource(Auth::user())
        ];
    }
}
