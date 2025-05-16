<?php

namespace App\Applications\Auth\Controllers;

use App\Applications\Auth\Requests\LoginRequest;
use App\Applications\Auth\Resources\UserMinimalResource;
use App\Domains\Auth\Services\AuthService;
use App\Support\Responses\ApiResponse;
use Illuminate\Support\Facades\Auth;

class AuthController
{

    public function __construct(protected AuthService $service)
    {
    }

    public function login(LoginRequest $request)
    {
        $result = $this->service->login($request->mobile, $request->password);

        if (!$result['success']) {
            return ApiResponse::error('موبایل یا رمز عبور اشتباه است', [], 401);
        }

        return ApiResponse::success('ورود موفقیت‌آمیز بود.', [
            'user' => new UserMinimalResource($result['user']),
        ])->cookie('token', $result['token'], 60 * 24);
    }

    public function logout()
    {
        Auth::logout();

        return ApiResponse::success('خروج با موفقیت انجام شد.')->withoutCookie('token');
    }

    public function me()
    {
        $user = Auth::user();

        return ApiResponse::success('اطلاعات کاربر بازیابی شد.', [
            'user' => new UserMinimalResource($user),
        ]);
    }
}
