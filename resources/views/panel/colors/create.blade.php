@extends('layouts.panel.master')

@section('title', 'رنگ‌ها')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد' => route('admin.dashboard'), 'رنگ‌ها' => route('admin.colors.index'), 'ایجاد رنگ' => route('admin.colors.create')]" title='کاربران' />
@endsection

@section('content')
    <x-form method="POST" :action="route('admin.colors.store')">
        <x-panel.card>

            <x-panel.card-header>
                <x-panel.card-title>
                   <x-panel.heading level="1"> ایجاد رنگ جدید</x-panel.heading>
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
                        <x-form.label id="code" class="required">کد</x-form.label>
                        <x-form.input type="color" class="form-control-color" name="code" value="{{ old('code') }}"/>
                        <x-form.input-error :messages="$errors->get('code')" class="mt-2" />
                    </x-panel.div-section>
                </x-panel.row>
            </x-panel.card-body>

            <x-panel.card-footer>
                <x-panel.div-section class="d-flex justify-content-end">

                    <x-form.btn-a :href="route('admin.colors.index')" class="btn-light me-3" title="لغو">
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
