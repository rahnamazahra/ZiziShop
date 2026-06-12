<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;



class VerifyMobileSMSController extends Controller
{

    public function __invoke(Request $request)
    {
        $enteredCode = $request->input('verification_code');

        if ($enteredCode != session()->get('verification_code')) {
            return redirect()->back()->withErrors(['error' => 'کد وارد شده صحیح نمی باشد.']);
        }

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
