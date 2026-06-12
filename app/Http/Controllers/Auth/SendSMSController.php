<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;


class SendSMSController extends Controller
{
    public function __invoke()
    {
        $mobile = session()->get('mobile');

        if (! $mobile) {
            return redirect()->route('auth.register.form');
        }

        $smsSent = false;
        $user = User::where('mobile', $mobile)->first();
        if ($user) {
            $smsSent = $user->checkSendingSmsCodeVerify();
        }

        return view('auth.verify-mobile', ['mobile' => $mobile, 'smsSent' => $smsSent]);
    }


}

