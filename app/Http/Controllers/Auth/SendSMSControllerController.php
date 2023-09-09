<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;


class SendSMSControllerController extends Controller
{
    public function __invoke($mobile)
    {
        session()->put('mobile', $mobile);

        //TODO $verificationCode = Str::randomNumber(6);
        $verificationCode = '123456';

        session()->put('verification_code', $verificationCode);

        //TODO send $verificationCode with sms to $mobile

        return view('auth.verify_mobile');
    }
}

