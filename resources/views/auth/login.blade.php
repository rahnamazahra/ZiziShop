@extends('layouts.site.lux')

@section('title', 'ورود — گالری رهنما')

@section('content')
    <div class="auth-wrap">
        <div class="auth-card">
            <div class="ornament"><i></i><b>✦</b><i></i></div>
            <h1 class="auth-title goldtext">گالری رهنما</h1>
            <p class="auth-sub">ورود | ثبت‌نام</p>

            <form method="POST" action="{{ route('auth.login.verify') }}">
                @csrf

                <label class="f-label" for="mobile">تلفن همراه</label>
                <input class="f-input input-just-number" type="text" id="mobile" name="mobile"
                       value="{{ old('mobile') }}" inputmode="numeric" maxlength="11"
                       placeholder="09xxxxxxxxx" autocomplete="off" dir="ltr" style="text-align:right;">
                @error('mobile') <div class="f-err">{{ $message }}</div> @enderror

                <label class="f-label" for="password">رمز عبور</label>
                <input class="f-input" type="password" id="password" name="password" autocomplete="off">
                @error('password') <div class="f-err">{{ $message }}</div> @enderror

                <div style="margin-top:24px;">
                    <button type="submit" class="buybtn" style="width:100%;">ورود</button>
                </div>
            </form>

            <p class="auth-foot">
                حساب کاربری ندارید؟
                <a href="{{ route('auth.register.form') }}">ایجاد حساب کاربری</a>
            </p>
        </div>
    </div>
@endsection
