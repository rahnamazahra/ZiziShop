@extends('layouts.site.lux')

@section('title', 'انتخاب مقصد — گالری رهنما')

@section('content')
    <div class="auth-wrap">
        <div class="auth-card">
            <div class="ornament"><i></i><b>✦</b><i></i></div>
            <h1 class="auth-title goldtext">خوش آمدید</h1>
            <p class="auth-sub">می‌خواهید کجا بروید؟</p>

            <div class="dest-links">
                <a href="{{ url('/') }}">سایت فروشگاه</a>
                <a href="{{ route('admin.dashboard') }}">پنل مدیریت</a>
            </div>
        </div>
    </div>
@endsection
