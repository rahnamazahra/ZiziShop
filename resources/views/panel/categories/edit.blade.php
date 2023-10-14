@extends('layouts.panel.master')

@section('title', 'دسته‌بندی')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد' => route('admin.dashboard'), 'دسته‌بندی' => route('admin.categories.index'), 'ویرایش دسته‌بندی' => route('admin.categories.edit', ['category' => $category])]" title='دسته‌بندی' />
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.categories.update', ['category' => $category]) }}" enctype='multipart/form-data' class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        @csrf
        @method('PATCH')

        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">

            <x-panel.card class="card-flush py-4">
                <x-panel.card-header>
                    <x-panel.card-title>
                        <x-panel.heading level="2">عکس</x-panel.heading>
                    </x-panel.card-title>
                </x-panel.card-header>

                <x-panel.card-body>
                    <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url('')">

                        @if($image)
                            <div class="image-input-wrapper w-250px h-250px" style="background-image: url('{{ $category->image_url }}')"></div>

                        @else
                            <div class="image-input-wrapper w-250px h-250px" style="background-image: url('{{ asset('') }}'); background-position: fixed;"></div>
                        @endif

                        <x-form.label id="image" class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="" data-bs-original-title="ویرایش عکس">

                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3"d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"fill="currentColor"></path>
                                </svg>
                            </span>

                            <input type="file" name="image" accept=".jpg, .jpeg" />

                        </x-form.label>

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
                        <x-form.input type="text" id="name" name="name" class="form-control mb-2" value="{{ old('name', $category->name) }}" />
                        <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-10 fv-row fv-plugins-icon-container">
                        <x-form.label id="slug">slug</x-form.label>
                        <x-form.input type="text" id="slug" name="slug" class="form-control mb-2" value="{{ old('slug', $category->slug) }}" />
                        <x-form.input-error :messages="$errors->get('slug')" class="mt-2" />
                    </div>

                    <div>
                        <label for="description">توضیحات</label>
                        <textarea id="description" name="description">
                            {{ old('description', $category->description) }}
                        </textarea>
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

    </form>
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

