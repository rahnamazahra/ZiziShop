@extends('layouts.panel.master')

@section('title', 'کاربران')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد' => route('admin.dashboard'), 'کاربران' => route('admin.users.index'), 'ایجاد کاربر' => route('admin.users.create')]" title='کاربران' />
@endsection

@section('content')
    <x-form method="POST" :action="route('admin.users.store')">
        <x-panel.card>

            <x-panel.card-header>
                <x-panel.card-title>
                   <x-panel.heading level="1"> ایجاد کاربر جدید</x-panel.heading>
                </x-panel.card-title>
            </x-panel.card-header>

            <x-panel.card-body>
                <x-panel.row>
                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="name" class="required">نام</x-form.label>
                        <x-form.input type="text" name="name" value="{{ old('name') }}"/>
                        <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="mobile" class="required">شماره موبایل</x-form.label>
                        <x-form.input type="text" name="mobile" value="{{ old('mobile') }}"/>
                        <x-form.input-error :messages="$errors->get('mobile')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="password" class="required">رمزعبور</x-form.label>
                        <x-form.input type="text" name="password" value="{{ old('password') }}"/>
                        <x-form.input-error :messages="$errors->get('password')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="password_confirmation" class="required">تکرار رمزعبور</x-form.label>
                        <x-form.input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"/>
                        <x-form.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </x-panel.div-section>

                </x-panel.row>
            </x-panel.card-body>

            <x-panel.card-footer>
                <x-panel.div-section class="d-flex justify-content-end">

                    <x-form.btn-a :href="route('admin.users.index')" class="btn-light me-3" title="لغو">
                        لغو
                    </x-form.btn-a>

                    <x-form.btn type="submit" class="btn-primary" title="ثبت">
                        ثبت
                    </x-form.btn>

                </x-panel.div-section>
            </x-panel.card-footer>

        </x-panel.card>
    </x-form>
@endsection
