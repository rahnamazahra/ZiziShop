@extends('layouts.panel.master')

@section('title', 'دسته‌بندی')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد' => route('admin.dashboard'), 'دسته‌بندی' => route('admin.categories.index'), 'ایجاد دسته‌بندی' => route('admin.categories.create')]" title='دسته‌بندی' />
@endsection

@section('content')
    <x-form method="POST" :action="route('admin.categories.store')" enctype='multipart/form-data' id="add_category_form" class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">

        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <x-panel.card class="card-flush py-4">
                <x-panel.card-header>
                    <x-panel.card-title>
                        <x-panel.heading level="2">عکس</x-panel.heading>
                    </x-panel.card-title>
                </x-panel.card-header>

                <x-panel.card-body>
                    <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url(assets/media/svg/files/blank-image.svg)">
                        <div class="image-input-wrapper w-150px h-150px"></div>

                        <x-form.label id="image" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow text-center" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="" data-bs-original-title="افزودن عکس اصلی">
                            <x-svg.icon-svg icon="edit" />
                            <x-form.input type="file" name="image" accept=".png, .jpg, .jpeg"  value="{{ old('image') }}"/>
                        </x-form.label>

                        <x-panel.span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="" data-bs-original-title="Cancel avatar">
                            <i class="bi bi-x fs-2"></i>
                        </x-panel.span>

                        <x-panel.span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="" data-bs-original-title="Remove avatar">
                            <i class="bi bi-x fs-2"></i>
                        </x-panel.span>

                    </div>

                    <div class="text-muted fs-7" dir="ltr"> *.png, *.jpg , *.jpeg </div>

                </x-panel.card-body>
            </x-panel.card>
        </div>


        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

            <x-panel.card class="card-flush py-4">
                <x-panel.card-header>
                    <x-panel.card-title>
                        <x-panel.heading level="2">تنظیمات عمومی</x-panel.heading>
                    </x-panel.card-title>
                </x-panel.card-header>

                <x-panel.card-body>
                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <x-form.label id="name" class="required">نام دسته بندی</x-form.label>
                        <x-form.input type="text" id="name" name="name" class="form-control mb-2" value="{{ old('name') }}" />
                        <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-form.label id="description">توضیحات</x-form.label>
                        <x-form.textarea rows="3" id="description" name="description">
                            {{ old('description') }}
                        </x-form.textarea>
                    </div>
                </x-panel.card-body>
            </x-panel.card>

            <div class="d-flex justify-content-end">
                <a href="../../demo1/dist/apps/ecommerce/catalog/products.html" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">لفو</a>
                <x-form.btn type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary" title="ثبت">
                    <x-panel.span>ثبت</x-panel.span>
                </x-form.btn>
            </div>

        </div>

        <div></div>

    </x-form>
@endsection

@section('custom-scripts')
    <script src='https://gitcdn.ir/library/ckeditor/4.13.0/ckeditor.js' type='text/javascript'></script>

    <script>
        CKEDITOR.replace('description', {
            language: 'fa',
            contentsLangDirection: 'rtl',
        });
    </script>


@endsection
