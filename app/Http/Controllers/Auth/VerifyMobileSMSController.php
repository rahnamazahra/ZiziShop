<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class VerifyMobileSMSController extends Controller
{

    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate([
            'verification_code' => 'required|string',
        ]);

        $verificationCode = $request->input('verification_code');
        $storedCode = Session::get('verification_code');

        if ($verificationCode === $storedCode) {
            Session::forget('verification_code');

            $user = User::where('mobile', $request->input('mobile'))->first();

            if ($user) {
                Auth::login($user);
                return redirect(RouteServiceProvider::MANAGMENT);

            } else {
                return redirect()->back()->with('error', 'شماره موبایل شما ثبت نشده است.');
            }

        } else {
            throw ValidationException::withMessages([
                'verification_code' => 'کدوارد شده صحیح نمی باشد.',
            ]);
        }
    }
}
