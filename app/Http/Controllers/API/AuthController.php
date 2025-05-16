<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserMinimalResource;
use App\Http\Resources\UserProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('mobile', 'password');
        $token = Auth::attempt($credentials);
    
        if (!$token) {
            return errorResponse('موبایل یا رمزعبور اشتباه است.', 401);
        }
    
        $user = Auth::user();
    
        return successResponse(
            ['user' => new UserMinimalResource($user)],
            'ورود موفقیت‌آمیز بود.'
        )->cookie(
            'token',
            $token,
            60 * 24,
            '/',
            null,
            true,
            true,
            false,
            'Strict'
        );
    }
    

    public function register(Request $request)
    {
       //
    }

    public function logout()
    {
        Auth::logout();

        return successResponse(
            null,
            'خروج با موفقیت انجام شد.'
        )->withoutCookie('token');
    }

    public function refresh()
    {
        $newToken = Auth::refresh();
        $user = Auth::user();

        return successResponse(
            ['user' => new UserMinimalResource($user)],
            'ورود موفقیت‌آمیز بود.'
        )->cookie(
            'token',
            $newToken,
            60 * 24,
            '/',
            null,
            true,
            true,
            false,
            'Strict'
        );
    }

    public function me()
    {
        $user = Auth::user();
        return successResponse( ['user' => new UserMinimalResource($user)],
        'ورود موفقیت‌آمیز بود.'
    );
    }

}
