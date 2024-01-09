@extends('layouts.auth.master')

@section('title', 'فعالسازی موبایل')

@section('content')
    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('auth.mobile.verify') }}">
            @csrf
            <x-form.input id="mobile" class="block mt-1 w-full" type="hidden" name="mobile" value="{{ $mobile }}"/>

            <div class="mt-4">
                <x-form.label id="mobile">کد</x-form.label>
                <x-form.input type="mobile" id="verification_code" name="verification_code" class="form-control mb-2 input-just-number" value="" autocomplete="off"/>
            </div>

            <x-panel.div-section class="text-center">
                <x-form.btn type="submit" class="btn btn-lg btn-primary btn-submit w-100 mb-5" title="">
                    <x-panel.span class="indicator-label">فعالسسازی</x-panel.span>
                    <x-panel.span class="indicator-progress">لطفا چندلحظه صبر کنید ...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </x-panel.span>
                </x-form.btn>
            </x-panel.div-section>
        </form>
    </div>
@endsection
