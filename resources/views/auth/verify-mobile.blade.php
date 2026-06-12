@extends('layouts.site.lux')

@section('title', 'فعال‌سازی موبایل — گالری رهنما')

@section('content')
    <div class="auth-wrap">
        <div class="auth-card">
            <div class="ornament"><i></i><b>✦</b><i></i></div>
            <h1 class="auth-title goldtext">فعال‌سازی موبایل</h1>
            <p class="auth-sub">کد تأیید پیامک‌شده به {{ fa_num($mobile) }} را وارد کنید</p>

            <form method="POST" action="{{ route('auth.mobile.verify') }}">
                @csrf
                <input type="hidden" name="mobile" value="{{ $mobile }}">

                <label class="f-label" for="verification_code">کد تأیید</label>
                <input class="f-input input-just-number" type="text" id="verification_code" name="verification_code"
                       inputmode="numeric" autocomplete="one-time-code" dir="ltr"
                       style="text-align:center;letter-spacing:.4em;font-size:18px;">
                @error('verification_code') <div class="f-err">{{ $message }}</div> @enderror
                @error('mobile') <div class="f-err">{{ $message }}</div> @enderror

                <div style="margin-top:24px;">
                    <button type="submit" class="buybtn" style="width:100%;">فعال‌سازی</button>
                </div>
            </form>

            <p class="auth-foot">
                کد دریافت نکردید؟
                <a href="{{ route('auth.mobile.sendCode') }}">ارسال دوباره کد</a>
            </p>
        </div>
    </div>
@endsection
