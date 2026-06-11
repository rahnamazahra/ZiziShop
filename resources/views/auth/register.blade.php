@extends('layouts.auth.master')

@section('title', 'ثبت نام')

@section('content')
<x-panel.div-section class="d-flex flex-column flex-root">
    <x-panel.div-section class="d-flex flex-column flex-column-fluid">
        <x-panel.div-section class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <x-panel.div-section class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">

                <form method="POST" action="{{ route('auth.register.store') }}" class="form w-100">
                    @csrf

                    <div class="text-center mb-10">
                        <h1 class="text-dark mb-3">ایجاد حساب کاربری</h1>
                        <div class="text-gray-400 fw-bold fs-6">گالری رهنما</div>
                    </div>

                    <div class="row">
                        <div class="fv-row mb-5 col-6">
                            <x-form.label id="first_name">نام</x-form.label>
                            <x-form.input type="text" id="first_name" name="first_name" class="form-control form-control-lg form-control-solid mb-2" value="{{ old('first_name') }}" autocomplete="off"/>
                            <x-form.input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>
                        <div class="fv-row mb-5 col-6">
                            <x-form.label id="last_name">نام خانوادگی</x-form.label>
                            <x-form.input type="text" id="last_name" name="last_name" class="form-control form-control-lg form-control-solid mb-2" value="{{ old('last_name') }}" autocomplete="off"/>
                            <x-form.input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>
                    </div>

                    <div class="fv-row mb-5">
                        <x-form.label id="mobile">تلفن‌همراه</x-form.label>
                        <x-form.input type="text" id="mobile" name="mobile" class="form-control form-control-lg form-control-solid mb-2 input-just-number" value="{{ old('mobile') }}" autocomplete="off"/>
                    </div>

                    <div class="fv-row mb-5">
                        <x-form.label id="password">رمزعبور</x-form.label>
                        <x-form.input type="password" id="password" name="password" class="form-control form-control-lg form-control-solid mb-2" value="" autocomplete="off"/>
                    </div>

                    <div class="fv-row mb-8">
                        <x-form.label id="password_confirmation">تکرار رمزعبور</x-form.label>
                        <x-form.input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg form-control-solid mb-2" value="" autocomplete="off"/>
                    </div>

                    <div class="text-center">
                        <x-form.btn type="submit" class="btn btn-lg btn-primary btn-submit w-100 mb-5" title="">
                            <x-panel.span class="indicator-label">مرحله بعد</x-panel.span>
                            <x-panel.span class="indicator-progress">لطفا چندلحظه صبر کنید ...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </x-panel.span>
                        </x-form.btn>

                        <div class="text-gray-400 fw-bold fs-6">
                            قبلاً ثبت‌نام کرده‌اید؟
                            <a href="{{ route('auth.login.form') }}" class="link-primary fw-bolder">ورود</a>
                        </div>
                    </div>
                </form>

            </x-panel.div-section>
        </x-panel.div-section>
    </x-panel.div-section>
</x-panel.div-section>
@endsection
