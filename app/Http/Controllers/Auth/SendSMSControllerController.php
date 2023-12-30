<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Tzsk\Sms\Facades\Sms;


class SendSMSControllerController extends Controller
{
    public function __invoke($mobile)
    {
        session()->put('mobile', $mobile);

        //TODO $verificationCode = Str::randomNumber(6);
        $verificationCode = '123456';

        session()->put('verification_code', $verificationCode);

        sms()->send("کدفعالسازی شما: " . $verificationCode)->to([$mobile])->dispatch();

        return view('auth.verify_mobile');
    }
}

