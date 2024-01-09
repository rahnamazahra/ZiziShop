@extends('layouts.auth.master')

@section('title', 'ثبت نام')

@section('content')
    <form method="POST" action="{{ route('auth.register.store') }}">
        @csrf
        <div class="mt-4">
            <x-form.label id="name">نام و نام خانوادگی</x-form.label>
            <x-form.input type="text" id="name" name="name" class="form-control mb-2 input-just-number" value="{{ old('name') }}" autocomplete="off"/>
        </div>

        <!-- mobile -->
        <div class="mt-4">
            <x-form.label id="mobile">تلفن‌همراه</x-form.label>
            <x-form.input type="mobile" id="mobile" name="mobile" class="form-control mb-2 input-just-number" value="{{ old('mobile') }}" autocomplete="off"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-form.label id="password">رمزعبور</x-form.label>
            <x-form.input type="password" id="password" name="password" class="form-control mb-2" value="" autocomplete="off"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-form.label id="password_confirmation">رمزعبور</x-form.label>
            <x-form.input type="password" id="password" name="password_confirmation" class="form-control mb-2" value="" autocomplete="off"/>
        </div>

        <x-panel.div-section class="text-center">
            <x-form.btn type="submit" class="btn btn-lg btn-primary btn-submit w-100 mb-5" title="">
                <x-panel.span class="indicator-label">مرحله بعد</x-panel.span>
                <x-panel.span class="indicator-progress">لطفا چندلحظه صبر کنید ...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </x-panel.span>
            </x-form.btn>
        </x-panel.div-section>
    </form>
@endsection
