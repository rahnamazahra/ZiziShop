<?php

namespace App\Http\Controllers\Auth;


use Illuminate\View\View;
use Illuminate\Http\Request;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Models\Cart;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

use App\Providers\RouteServiceProvider;


class LoginController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function checkLogin(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('mobile', 'password');
        $guestToken  = session('cart_token'); // ذخیره قبل از regenerate

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            $request->session()->regenerate();

            // ادغام سبد مهمان با سبد کاربر
            if ($guestToken) {
                Cart::mergeGuestIntoUser($guestToken, $user);
            }

            if ($user->roles()->count() > 0) {
                return redirect()->route('auth.choose-destination');
            }

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return redirect()->back()->with('swal', [
            'title'   => 'خطا!',
            'message' => 'موبایل یا رمزعبور اشتباه می باشد.',
            'icon'    => 'error',
        ]);
    }

    public function showChooseDestination(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        $user = Auth::guard('web')->user();
        if (!$user || $user->roles()->count() === 0) {
            return redirect(RouteServiceProvider::HOME);
        }
        return view('auth.choose-destination');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.login.form');
    }
}
