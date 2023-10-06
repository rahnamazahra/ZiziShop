@extends('layouts.panel.master')

@section('title', 'دسته‌بندی')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد' => route('admin.dashboard'), 'دسته‌بندی' => route('admin.categories.index'), 'ویرایش دسته‌بندی' => route('admin.categories.edit', ['id' => $category->id])]" title='دسته‌بندی' />
@endsection

@section('content')
    <x-form.layout method="PATCH" :action="route('admin.categories.update', ['id' => $category->id])" enctype='multipart/form-data' id="add_category_form" class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">

        <x-panel.div-section class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">

            <x-panel.card class="card-flush py-4">
                <x-panel.card-header>
                    <x-panel.card-title>
                        <x-panel.heading level="2">عکس</x-panel.heading>
                    </x-panel.card-title>
                </x-panel.card-header>

                <x-panel.card-body>
                    <x-panel.div-section class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url('')">

                        @if($image)
                            <x-panel.div-section class="image-input-wrapper w-250px h-250px" style="background-image: url('{{ asset('/upload/'. $image) }}')"></x-panel.div-section>

                        @else
                            <x-panel.div-section class="image-input-wrapper w-250px h-250px" style="background-image: url('{{ asset('') }}')"></x-panel.div-section>
                        @endif

                        <x-form.label id="image" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="" data-bs-original-title="افزودن عکس">
                            <i class="bi bi-pencil-fill fs-7"></i>
                            <x-form.input type="file" name="image" accept=".png, .jpg, .jpeg"  value="{{ old('image') }}"/>
                        </x-form.label>

                    </x-panel.div-section>

                    <x-panel.div-section class="text-muted fs-7" dir="ltr"> *.png, *.jpg , *.jpeg </x-panel.div-section>

                </x-panel.card-body>
            </x-panel.card>

            <x-panel.card class="card-flush py-4">

                <x-panel.card-header>
                    <x-panel.card-title class="card-title">
                        <x-panel.heading level="2">وضعیت</x-panel.heading>
                    </x-panel.card-title>

                    <div class="card-toolbar">
                        <div class="rounded-circle @if($category->status) bg-success @else bg-danger @endif w-15px h-15px" id="kt_ecommerce_add_category_status"></div>
                    </div>
                </x-panel.card-header>

                <x-panel.card-body>
                    <select name="status" class="form-select mb-2 select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select an option" id="kt_ecommerce_add_category_status_select" data-select2-id="select2-data-kt_ecommerce_add_category_status_select" tabindex="-1" aria-hidden="true">
                        <option></option>
                        <option value="1" @if($category->status) selected="selected" @endif data-select2-id="select2-data-11-c0ii">انتشار</option>
                        <option value="0" @unless($category->status) selected="selected" @endunless>عدم انتشار</option>
                    </select>
                </x-panel.card-body>

            </x-panel.card>
        </x-panel.div-section>


        <x-panel.div-section class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

            <x-panel.card class="card-flush py-4">
                <x-panel.card-header>
                    <x-panel.card-title>
                        <x-panel.heading level="2">تنظیمات عمومی</x-panel.heading>
                    </x-panel.card-title>
                </x-panel.card-header>

                <x-panel.card-body>
                    <x-panel.div-section class="mb-10 fv-row fv-plugins-icon-container">
                        <x-form.label id="name" class="required">نام دسته بندی</x-form.label>
                        <x-form.input type="text" id="name" name="name" class="form-control mb-2" value="{{ old('name', $category->name) }}" />
                        <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section>
                        <x-form.label id="description">توضیحات</x-form.label>
                        <x-form.textarea rows="3" id="description" name="description">
                            {{ old('description', $category->description) }}
                        </x-form.textarea>
                    </x-panel.div-section>
                </x-panel.card-body>
            </x-panel.card>

            <x-panel.div-section class="d-flex justify-content-end">
                <a href="../../demo1/dist/apps/ecommerce/catalog/products.html" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">لفو</a>
                <x-form.btn type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary" title="ثبت">
                    <x-panel.span>ثبت</x-panel.span>
                </x-form.btn>
            </x-panel.div-section>

        </x-panel.div-section>

    </x-form.layout>
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

