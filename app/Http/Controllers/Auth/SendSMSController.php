<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;


class SendSMSController extends Controller
{
    public function __invoke()
    {
        $mobile = session()->get('mobile');
        $user = User::where('mobile', $mobile)->first();
        if($user) {
            $result = $user->checkSendingSmsCodeVerify();
        }

        return view('auth.verify-mobile');

    }


}

