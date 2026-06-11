@extends('layouts.panel.master')

@section('title', 'سایزها')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد' => route('admin.dashboard'), 'سایزها' => route('admin.sizes.index'), 'ایجاد سایز' => route('admin.sizes.create')]" title='سایزها' />
@endsection

@section('content')
    <x-form method="POST" :action="route('admin.sizes.store')">
        <x-panel.card>

            <x-panel.card-header>
                <x-panel.card-title>
                   <x-panel.heading level="1">ایجاد سایز جدید</x-panel.heading>
                </x-panel.card-title>
            </x-panel.card-header>

            <x-panel.card-body>
                <x-panel.row>
                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="name" class="required">نام سایز</x-form.label>
                        <x-form.input type="text" name="name" value="{{ old('name') }}" placeholder="مثلاً ۱۵ سانتی‌متر"/>
                        <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
                    </x-panel.div-section>
                </x-panel.row>
            </x-panel.card-body>

            <x-panel.card-footer>
                <x-panel.div-section class="d-flex justify-content-end">

                    <x-form.btn-a :href="route('admin.sizes.index')" class="btn-light me-3" title="لغو">
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
