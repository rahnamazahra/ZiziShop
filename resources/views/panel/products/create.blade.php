@extends('layouts.panel.master')

@section('title', 'محصول')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد' => route('admin.dashboard'), 'محصولات' => route('admin.products.index'), 'ایجاد محصول' => route('admin.products.create')]" title='محصول' />
@endsection

@section('content')

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row fv-plugins-bootstrap5 fv-plugins-framework">
        @csrf

        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">

            <x-panel.card class="card-flush py-4">

                <x-panel.card-header>
                    <x-panel.card-title class="card-title">
                        <x-panel.heading level="2">وضعیت</x-panel.heading>
                    </x-panel.card-title>

                    <x-panel.card-toolbar>
                        <div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_product_status"></div>
                    </x-panel.card-toolbar>
                </x-panel.card-header>

                <x-panel.card-body>
                    <select name="is_published" id="is_published" class="form-select mb-2 select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select an option" tabindex="-1" aria-hidden="true">
                        <option></option>
                        <option value="1" @selected(old('is_published')) selected="selected" data-select2-id="select2-data-11-c0ii">انتشار</option>
                        <option value="0" @selected(!old('is_published'))>عدم انتشار</option>
                    </select>

                    <select name="is_healthy" id="is_healthy" class="form-select mb-2 select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select an option" tabindex="-1" aria-hidden="true">
                        <option></option>
                        <option value="1" @selected(old('is_healthy')) selected="selected">سالم</option>
                        <option value="0" @selected(!old('is_healthy'))>ایراد جزئی</option>
                    </select>
                </x-panel.card-body>

            </x-panel.card>

            <x-panel.card class="card-flush py-4">
                <x-panel.card-header>
                    <x-panel.card-title class="card-title required">
                        <x-panel.heading level="2">دسته‌بندی</x-panel.heading>
                    </x-panel.card-title>
                </x-panel.card-header>

				<x-panel.card-body>
                    <select name="category_id" id="category_id" class="form-select mb-2 select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="یک مورد را انتخاب کنید" tabindex="-1" aria-hidden="true">
                        <option></option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <div>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-light-primary btn-sm">
                            <x-svg.icon-svg icon="add" />
                            ایجاد دسته‌بندی جدید
                        </a>
                    </div>

                    <x-form.input-error :messages="$errors->get('category_id')" class="mt-2" />

                </x-panel.card-body>
            </x-panel.card>

        </div>

        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

            <x-panel.ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2">
                <x-panel.li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#add_product_general">عمومی</a>
                </x-panel.li>

                <x-panel.li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#add_product_advanced">پیشرفته</a>
                </x-panel.li>
            </x-panel.ul>

            <div class="tab-content">

                <div id="add_product_general" class="tab-pane fade show active" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

                            <x-panel.card class="card-flush py-4">
                                <x-panel.card-header>
                                    <x-panel.card-title>
                                        <x-panel.heading level="2">تنظیمات عمومی</x-panel.heading>
                                    </x-panel.card-title>
                                </x-panel.card-header>

                                <x-panel.card-body>
                                    <div class="mb-10 fv-row fv-plugins-icon-container">
                                        <x-form.label id="name" class="required">نام محصول</x-form.label>
                                        <x-form.input type="text" id="name" name="name" class="form-control mb-2" value="{{ old('name') }}" />
                                        <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <div class="mb-10 fv-row fv-plugins-icon-container">
                                        <x-form.label id="slug">slug</x-form.label>
                                        <x-form.input type="text" id="slug" name="slug" class="form-control mb-2" value="{{ old('slug') }}" />
                                        <x-form.input-error :messages="$errors->get('slug')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-form.label id="description">توضیحات</x-form.label>
                                        <x-form.textarea rows="3" id="description" name="description">
                                            {{ old('description') }}
                                        </x-form.textarea>
                                    </div>
                                </x-panel.card-body>
                            </x-panel.card>

                            <x-panel.card class="card-flush py-4">
                                <x-panel.card-header>
                                    <x-panel.card-title>
                                        <x-panel.heading level="2">تصاویر</x-panel.heading>
                                    </x-panel.card-title>
                                </x-panel.card-header>

                                {{--  <x-panel.card-body>
                                    <div class="fv-row mb-2">
                                        <input type="file" name="images"  class="form-control" multiple>
                                    </div>

                                    <div class="text-muted fs-7">عکس‌های بیشتری برای محصول انتخاب نمایید.</div>

                                </x-panel.card-body>  --}}
                            </x-panel.card>

                            <div class="card card-flush py-4">

                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>قیمت</h2>
                                    </div>
                                </div>

                                <div class="card-body pt-0">

                                    <div class="mb-10 fv-row">
                                        <label for="price" class="required form-label">قیمت</label>
                                        <input type="text" name="price" id="price" class="form-control mb-2" placeholder="قیمت (ریال)" value="{{ old('price') }}" />
                                        <div class="text-muted fs-7">قیمت محصول را وارد نمایید</div>
                                        <x-form.input-error :messages="$errors->get('price')" class="mt-2" />
                                    </div>

                                    <div class="fv-row mb-10">
                                        <label for="discount" class="fs-6 fw-bold mb-2">  تخفیف %</label>
                                        <input type="text" name="discount" id="discount" class="form-control mb-2" value="{{ old('discount', 0) }}" />
                                        <x-form.input-error :messages="$errors->get('discount')" class="mt-2" />

                                    </div>

                                </div>
                            </div>

                            <x-panel.card class="card-flush py-4">
                                <x-panel.card-header>
                                    <x-panel.card-title>
                                        <x-panel.heading level="2">
                                            تنظیمات تگ
                                        </x-panel.heading>
                                    </x-panel.card-title>
                                </x-panel.card-header>

                                <x-panel.card-body>

                                    <div>
                                        <x-form.label id="tags" class="required">تگ‌ها</x-form.label>

                                        <x-form.input type="text" id="tags" name="tags" class="form-control mb-2" value="{{ old('tags') }}"/>
                                        <x-form.input-error :messages="$errors->get('tags')" class="mt-2" />

                                        <div class="text-muted fs-7">
                                        فهرستی از کلمات کلیدی را تنظیم کنید که مقوله مربوط به محصول است. کلمات کلیدی را با اضافه کردن کاما از هم جدا کنید
                                            <code>،</code>بین هر کلمه باشد.
                                        </div>

                                    </div>

                                </x-panel.card-body>
                            </x-panel.card>

                        </div>
                    </div>
                </div>

                <div id="add_product_advanced" class="tab-pane fade" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <x-panel.card class="card-flush py-4">
                            <x-panel.card-header>
                                <x-panel.card-title>
                                    <x-panel.heading level="2">جزییات وزن و اندازه</x-panel.heading>
                                </x-panel.card-title>
                            </x-panel.card-header>

                            <x-panel.card-body>
                                <div id="add_product_weight">

                                    <div class="mb-10 fv-row">

                                        <x-form.label id="weight" class="form-label">وزن</x-form.label>

                                        <x-form.input type="text" name="weight" class="form-control mb-2" placeholder="وزن محصول" value="{{ old('weight') }}" />

                                        <div class="text-muted fs-7">وزن محصول را بر حسب کیلوگرم (Kg) تنظیم کنید.</div>

                                    </div>


                                    <div class="fv-row">

                                        <x-form.label id="dimention" class="form-label">ابعاد</x-form.label>

                                        <div class="d-flex flex-wrap flex-sm-nowrap gap-3">
                                            <x-form.input type="number" name="width" class="form-control mb-2" placeholder="(w)عرض" value="{{ old('width') }}" />
                                            <x-form.input type="number" name="height" class="form-control mb-2" placeholder="(h)ارتفاع" value="{{ old('height') }}" />
                                            <x-form.input type="number" name="length" class="form-control mb-2" placeholder="(l)طول" value="{{ old('length') }}" />
                                        </div>

                                        <div class="text-muted fs-7">ابعاد محصول را به سانتی متر (cm) وارد کنید.</div>

                                    </div>

                                </div>
                            </x-panel.card-body>
                        </x-panel.card>

                        <x-panel.card class="card-flush py-4">

                            <x-panel.card-header>

                                <x-panel.card-title>
                                    <x-panel.heading level="2">جزییات</x-panel.heading>
                                </x-panel.card-title>

                            </x-panel.card-header>

							<x-panel.card-body>

								<div class="mb-10 fv-row fv-plugins-icon-container">
									<x-form.label id="sku" class="form-label">SKU</x-form.label>
                                    <x-form.input type="text" name="sku" class="form-control mb-2" placeholder="SKU Number" value="{{ old('sku') }}" />
                                    <div class="text-muted fs-7">شناسه منحصربفرد (SKU) مربوط به محصول را وارد کنید</div>
                                </div>

								<div class="mb-10 fv-row fv-plugins-icon-container">
                                    <x-form.label id="barcode" class="orm-label">بارکد</x-form.label>
                                    <x-form.input type="text" name="barcode" class="form-control mb-2" placeholder="بارکد" value="{{ old('barcode') }}" />
                                    <div class="text-muted fs-7">بارکد مربوط به محصول را وارد نمایید.</div>
                                </div>

								<div class="mb-10 fv-row fv-plugins-icon-container">
                                    <x-form.label id="inventory" class="form-label">موجودی</x-form.label>

                                    <div class="d-flex gap-3">
                                        <x-form.input type="number" name="inventory" class="form-control mb-2" value="{{ old('inventory', 0) }}" />
                                    </div>

                                    <div class="text-muted fs-7">تعداد کل محصول را وارد نمایید</div>
                                </div>

                            </x-panel.card-body>
                        </x-panel.card>

                         <x-panel.card class="card-flush py-4">

                            <x-panel.card-header>

                                <x-panel.card-title>
                                    <x-panel.heading level="2">ویژگی‌های محصول</x-panel.heading>
                                </x-panel.card-title>

                            </x-panel.card-header>

							<x-panel.card-body>
                                <!--begin::Repeater-->
                                <div id="features">
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <div data-repeater-list="features">
                                            <div data-repeater-item>
                                                <div class="form-group row">
                                                    <div class="fv-row fv-plugins-icon-container col-md-3">
                                                        <x-form.label id="feature_key" class="form-label">عنوان</x-form.label>
                                                        <x-form.input type="text" name="feature_key" class="form-control mb-2" placeholder="عنوان ویژگی" value="" />
                                                    </div>

                                                    <div class="mb-10 fv-row fv-plugins-icon-container col-md-8">
                                                        <x-form.label id="feature_value" class="form-label">توضیحات وِیژگی</x-form.label>
                                                        <x-form.input type="text" name="feature_value" class="form-control mb-2" placeholder="توضیحات" value="" />
                                                    </div>

                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                            <i class="la la-trash-o"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Form group-->

                                    <!--begin::Form group-->
                                    <div class="d-flex justify-content-end form-group mt-5">
                                        <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                            <i class="la la-plus"></i>افزودن ویژگی
                                        </a>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                                <!--end::Repeater-->
                            </x-panel.card-body>
                        </x-panel.card>

                        <x-panel.card class="card-flush py-4">

                            <x-panel.card-header>
                                <x-panel.card-title>
                                    <x-panel.heading level="2">تنوع محصول</x-panel.heading>
                                </x-panel.card-title>
                            </x-panel.card-header>

							<x-panel.card-body>
								 <!--begin::Repeater-->
                                <div id="repeater_variety">
                                    <!--begin::Form group-->
                                    <div class="form-group">
                                        <div data-repeater-list="repeater_variety">
                                            <div data-repeater-item>
                                                <div class="form-group row">

                                                    <div class="fv-row fv-plugins-icon-container col-md-4">
                                                        <label for="size" class="form-label">سایز</label>
                                                        <select class="form-select form-select-solid" name="size" data-control="select2" data-placeholder="لطفا انتخاب کنید">
                                                            <option></option>
                                                            @foreach($sizes as $size)
                                                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-10 fv-row fv-plugins-icon-container col-md-4">
                                                        <label for="color" class="form-label">رنگ</label>
                                                        <select class="form-select form-select-solid" name="color" data-control="select2" data-placeholder="لطفا انتخاب کنید">
                                                            <option></option>
                                                            @foreach($colors as $color)
                                                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-10 fv-row fv-plugins-icon-container col-md-3">
                                                        <label for="inventory"  class="form-label">تعداد</label>
                                                        <x-form.input type="number"  name="product_inventory" class="form-control mb-2" placeholder="تعداد" value="" />
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                            <i class="la la-trash-o"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Form group-->

                                    <!--begin::Form group-->
                                    <div class="d-flex justify-content-end form-group mt-5">
                                        <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                            <i class="la la-plus"></i>افزودن تنوع
                                        </a>
                                    </div>
                                    <!--end::Form group-->
                                </div>
                                <!--end::Repeater-->
                            </x-panel.card-body>

                        </x-panel.card>

                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.products.index') }}" class="btn btn-light me-5">لفو</a>
                <x-form.btn type="submit" class="btn btn-primary" title="ثبت">
                    <x-panel.span>ثبت</x-panel.span>
                </x-form.btn>
            </div>

        </div>

        <div></div>

    </form>
@endsection

@section('custom-scripts')
    <script src='https://gitcdn.ir/library/ckeditor/4.13.0/ckeditor.js' type='text/javascript'></script>
    <script src="{{ asset('panel/assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>

    <script>
        CKEDITOR.replace('description', {
            language: 'fa',
            contentsLangDirection: 'rtl',
        });
    </script>


    <script>
    /*var myDropzone = new Dropzone("#imagesDropzone", {
        url: "",
        paramName: "images",
        maxFilesize: 2,
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(response) {
           //
        },
        error: function(response) {
            //
        }
    });*/
    </script>

    <script>
        $('#features').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });

        $('#repeater_variety').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    </script>
@endsection

