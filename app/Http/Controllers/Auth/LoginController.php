<?php

namespace App\Http\Controllers\Auth;


use Illuminate\View\View;
use Illuminate\Http\Request;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

use App\Providers\RouteServiceProvider;


class LoginController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function checkLogin(LoginRequest $request): RedirectResponse {

        $credentials = $request->only('mobile', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);

        } else {
            return redirect()->back()->with('swal', [
                    'title' => 'خطا!',
                    'message' => 'موبایل یا رمزعبور اشتباه می باشد.',
                    'icon' => 'error',
            ]);
        }

    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
