<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Providers\RouteServiceProvider;



class VerifyMobileSMSController extends Controller
{

    public function __invoke(Request $request)
    {
        $enteredCode = (string) $request->input('verification_code');
        $mobile      = (string) $request->input('mobile');

        $validCode = (string) (Cache::get('otp_' . $mobile) ?? session('verification_code'));

        if ($enteredCode !== $validCode || $validCode === '') {
            return redirect()->back()->withErrors(['error' => 'کد وارد شده صحیح نمی‌باشد یا منقضی شده است.']);
        }

        Cache::forget('otp_' . $mobile);
        session()->forget('verification_code');

        $user = User::where('mobile', $request->input('mobile'))->first();

        if (! $user) {
            return redirect()->route('auth.login.form');
        }

        $user->mobile_verified_at = Carbon::now();
        $user->save();

        // ذخیره توکن سبد مهمان پیش از regenerate
        $guestToken = session('cart_token');

        // لاگین خودکار پس از تأیید موبایل
        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        // ادغام سبد مهمان با سبد کاربر
        if ($guestToken) {
            Cart::mergeGuestIntoUser($guestToken, $user);
        }

        return redirect(RouteServiceProvider::HOME)->with('success', 'ثبت‌نام با موفقیت انجام شد. خوش آمدید!');
    }
}
