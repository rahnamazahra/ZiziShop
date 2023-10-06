@extends('layouts.auth.master')

@section('title', 'ورود')

@section('content')
<x-panel.div-section class="d-flex flex-column flex-root">
	<x-panel.div-section class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/sketchy-1/14.png">
		<x-panel.div-section class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
			<x-panel.div-section class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
				<x-form.layout method="POST" action="{{ route('auth.login.verify') }}" class="form w-100" novalidate="novalidate" id="kt_sign_in_form" >

					<x-panel.div-section class="text-center mb-10">
				        <img alt="Logo" src="{{ asset('/images/logo/logo.png') }}" class="h-80px mb-5" />
                        <x-panel.heading level="1">
                            ورود | ثبت‌نام
                        </x-panel.heading>
					</x-panel.div-section>

                    <x-panel.div-section class="mb-10 fv-row fv-plugins-icon-container">
                        <x-form.label id="mobile">تلفن‌همراه</x-form.label>
                        <x-form.input type="mobile" id="name" name="mobile" class="form-control mb-2 input-just-number" value="{{ old('mobile') }}" autocomplete="off"/>
                        <x-form.input-error :messages="$errors->get('mobile')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section class="mb-10 fv-row fv-plugins-icon-container">
                        <x-form.label id="password">رمزعبور</x-form.label>
                        <x-form.input type="password" id="password" name="password" class="form-control mb-2" value="{{ old('password') }}" autocomplete="off"/>
                        <x-form.input-error :messages="$errors->get('password')" class="mt-2" />
                    </x-panel.div-section>


					<x-panel.div-section class="text-center">
						<x-form.btn type="submit" class="btn btn-lg btn-primary btn-submit w-100 mb-5" title="">
							<x-panel.span class="indicator-label">ورود</x-panel.span>
							<x-panel.span class="indicator-progress">لطفا چندلحظه صبر کنید ...
								<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
							</x-panel.span>
						</x-form.btn>

                        <x-panel.div-section class="text-gray-400">
							<a href="" class="link-primary fw-bolder">ایجاد حساب کاربری</a>
						</x-panel.div-section>
					</x-panel.div-section>

				</x-form.layout>
			</x-panel.div-section>
		</x-panel.div-section>
	</x-panel.div-section>
</x-panel.div-section>
@endsection
