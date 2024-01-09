<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;



class VerifyMobileSMSController extends Controller
{

    public function __invoke(Request $request)
    {
        $enteredCode = $request->input('verification_code');

        if ($enteredCode == session()->get('verification_code')) {

            session()->forget('verification_code');

            $user = User::where('mobile', $request->input('mobile'))->first();

            if ($user) {
                $user->mobile_verified_at = Carbon::now();
                $user->save();
            }

            return redirect()->route('auth.login.form')->with('success', 'Mobile number verified successfully.');

        } else {
            return redirect()->back()->withErrors(['error' => 'کد وارد شده صحیح نمی باشد.']);
        }
    }
}
