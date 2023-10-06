@extends('layouts.panel.master')

@section('title', 'کاربران')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد' => route('admin.dashboard'), 'کاربران' => route('admin.users.index'), 'ویرایش کاربر' => route('admin.users.create')]" title='کاربران' />
@endsection

@section('content')
    <x-form.layout method="PATCH" :action="route('admin.users.update',['id' => $user->id])">
        <x-panel.card>

            <x-panel.card-header>
                <x-panel.card-title>
                   <x-panel.heading level="1"> ویرایش کاربر {{ $user->name }}</x-panel.heading>
                </x-panel.card-title>
            </x-panel.card-header>

            <x-panel.card-body>
                <x-panel.row>
                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="name" class="required" label="نام"/>
                        <x-form.input type="text" name="name" value="{{ old('name' , $user->name) }}"/>
                        <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="mobile" class="required" label="شماره موبایل"/>
                        <x-form.input type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}"/>
                        <x-form.input-error :messages="$errors->get('mobile')" class="mt-2" />
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
    </x-form.layout>
@endsection
