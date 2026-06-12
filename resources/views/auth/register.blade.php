@extends('layouts.site.lux')

@section('title', 'ثبت‌نام — گالری رهنما')

@section('content')
    <div class="auth-wrap">
        <div class="auth-card">
            <div class="ornament"><i></i><b>✦</b><i></i></div>
            <h1 class="auth-title goldtext">ایجاد حساب کاربری</h1>
            <p class="auth-sub">گالری رهنما</p>

            <form method="POST" action="{{ route('auth.register.store') }}">
                @csrf

                <div class="auth-row">
                    <div>
                        <label class="f-label" for="first_name">نام</label>
                        <input class="f-input" type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" autocomplete="off">
                        @error('first_name') <div class="f-err">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="f-label" for="last_name">نام خانوادگی</label>
                        <input class="f-input" type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" autocomplete="off">
                        @error('last_name') <div class="f-err">{{ $message }}</div> @enderror
                    </div>
                </div>

                <label class="f-label" for="mobile">تلفن همراه</label>
                <input class="f-input input-just-number" type="text" id="mobile" name="mobile"
                       value="{{ old('mobile') }}" inputmode="numeric" maxlength="11"
                       placeholder="09xxxxxxxxx" autocomplete="off" dir="ltr" style="text-align:right;">
                @error('mobile') <div class="f-err">{{ $message }}</div> @enderror

                <label class="f-label" for="password">رمز عبور</label>
                <input class="f-input" type="password" id="password" name="password" autocomplete="off">
                @error('password') <div class="f-err">{{ $message }}</div> @enderror

                <label class="f-label" for="password_confirmation">تکرار رمز عبور</label>
                <input class="f-input" type="password" id="password_confirmation" name="password_confirmation" autocomplete="off">
                @error('password_confirmation') <div class="f-err">{{ $message }}</div> @enderror

                <div style="margin-top:24px;">
                    <button type="submit" class="buybtn" style="width:100%;">مرحله بعد</button>
                </div>
            </form>

            <p class="auth-foot">
                قبلاً ثبت‌نام کرده‌اید؟
                <a href="{{ route('auth.login.form') }}">ورود</a>
            </p>
        </div>
    </div>
@endsection
