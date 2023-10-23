@extends('layouts.panel.master')

@section('title', 'محصولات')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'محصولات' => route('admin.products.index')]" title='محصولات' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>

            <x-panel.card-title>
                <x-panel.search :action="route('admin.products.index', ['search'])" />

                <x-form.btn type="button" class="btn-outline btn-outline-light btn-active-light" title="فیلتر" data-bs-toggle="collapse" data-bs-target="#filter_search">
                    <x-svg.icon-svg icon='filter' />
                </x-form.btn>

                @if (request()->has('search') or request()->has('category'))
                    <x-form.btn-a :href="route('admin.products.index')" class="btn-light-primary" title="حذف فیلتر">
                        حذف فیلتر
                    </x-form.btn-a>
                @endif

            </x-panel.card-title>

            <x-panel.card-toolbar>

                <x-form.btn-a :href="route('admin.products.create')" class="btn-primary" title="ایجاد محصول جدید">
                    ایجاد محصول جدید
                </x-form.btn-a>

                <form method="POST" action="{{ route('admin.products.export') }}">
                    @csrf

                    <input type="hidden" name="search" value="{{ request()->has('search') ? request()->query('search') : '' }}">

                    <input type="hidden" name="is_published" value="{{ request()->has('is_published') ? request()->query('is_published') : '' }}">

                    <input type="hidden" name="is_healthy" value="{{ request()->has('is_healthy') ? request()->query('is_healthy') : '' }}">

                    <input type="hidden" name="category" value="{{ request()->has('category') ? request()->query('category') : '' }}">

                    <x-form.btn class="btn-light-primary" title="expoert Excel">
                        Export Excel
                        <x-svg.icon-svg icon="export" />
                    </x-form.btn>
                </form>

                @if (request()->has('trashed'))
                    <x-form.btn-a :href="route('admin.products.index')" class="btn-light" title="برگشت">
                        <x-svg.icon-svg icon="back" />
                    </x-form.btn-a>
                @else
                    <x-form.btn-a :href="route('admin.products.index', ['trashed'])" class="btn-light" title="سطل‌زباله">
                        <x-svg.icon-svg icon="delete" />
                    </x-form.btn-a>
                @endif

            </x-panel.card-toolbar>
        </x-panel.card-header>

        <x-panel.card-body>

             <div id="filter_search" class="flex collapse">
                <x-form method="GET" :action="route('admin.products.index')">
                    <div class="row mb-8">

                        <div class="col-md-2 fv-row">
                            <div class="d-flex align-items-center fw-bolder" data-select2-id="select2-data-122-u471">
                                <div class="text-gray-400 fs-7 me-2">دسته‌بندی</div>
                                <select name="category" id="category" class="form-select form-select-transparent text-graY-800 fs-base lh-1 fw-bolder py-0 ps-3 w-auto select2-hidden-accessible" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px" data-placeholder="لطفا انتخاب کنید" tabindex="-1" aria-hidden="true">
                                    <option @selected(! request()->filled('category')) value=" ">همه</option>
                                    @foreach($categories as $category)
                                        <option @selected(request()->query('category') == $category->id) value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 fv-row">
                            <div class="d-flex align-items-center fw-bolder" data-select2-id="select2-data-122-u471">
                                <div class="text-gray-400 fs-7 me-2">وضعیت</div>
                                <select name="is_published" id="is_published" class="form-select form-select-transparent text-graY-800 fs-base lh-1 fw-bolder py-0 ps-3 w-auto select2-hidden-accessible" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px" data-placeholder="همه" tabindex="-1" aria-hidden="true">
                                    <option @selected(! request()->filled('is_published')) value=" ">همه</option>
                                    <option @selected(request()->query('is_published') == '1') value="1">انتشار</option>
                                    <option @selected(request()->query('is_published') == '0') value="0">عدم انتشار</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 fv-row">
                            <div class="d-flex align-items-center fw-bolder" data-select2-id="select2-data-122-u471">
                                <div class="text-gray-400 fs-7 me-2">سلامت</div>
                                <select name="is_healthy" id="is_healthy" class="form-select form-select-transparent text-graY-800 fs-base lh-1 fw-bolder py-0 ps-3 w-auto select2-hidden-accessible" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px" data-placeholder="همه" tabindex="-1" aria-hidden="true">
                                    <option @selected(! request()->filled('is_published')) value=" ">همه</option>
                                    <option @selected(request()->query('is_healthy') == '1') value="1">سالم</option>
                                    <option @selected(request()->query('is_healthy') == '0') value="0">ایرادجزئی</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <x-form.btn type="submit" class="btn btn-sm btn-primary" title="جست‌وجو">جست‌و‌جو</x-form.btn>
                        </div>

                    </div>
                </x-form>
            </div>

            <x-table>
                <x-tr>
                    <x-th></x-th>
                    <x-th></x-th>
                    <x-th>وضعیت</x-th>
                    <x-th>SKU</x-th>
                    <x-th>بارکد</x-th>
                    <x-th>تعداد</x-th>
                    <x-th>قیمت</x-th>
                    <x-th>اقدامات</x-th>
                </x-tr>


                @forelse ($products as $product)

                    <x-tr>
                        <x-td>
                            <div class="d-flex align-items-center">

                                <a href="" class="symbol symbol-50px">
                                    <span class="symbol-label" style="background-image:url('{{ $product->image_url }}');"></span>
                                </a>

                                <div class="ms-5">
                                    <a href="" class="text-gray-800 text-hover-primary fs-4 fw-bolder" data-kt-ecommerce-product-filter="product_name">{{ $product->name ?? '-' }}</a>
                                    <div class="text-gray-600 fs-7">
                                      {{ $product->get_category ?? '-'}}
                                    </div>
                                </div>

                            </div>
                        </x-td>

                        <x-td>
                            <div class="text-end pe-0" data-order="rating-3">
                                <div class="rating justify-content-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div class="rating-label {{ $product->get_rating >= $i ? 'checked' : '' }}">
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </x-td>

                        <x-td>
                            <div class="badge {{ $product->is_healthy ? 'badge-light-success' : 'badge-light-danger' }}">
                                {{ $product->status_healty_label }}
                            </div>

                            <div class="badge {{ $product->is_published ? 'badge-light-success' : 'badge-light-danger' }}">
                                {{ $product->status_published_label }}
                            </div>
                        </x-td>

                        <x-td>
                            {{ $product->sku ?? '-'}}
                        </x-td>

                        <x-td>
                            {{ $product->barcode ?? '-'}}
                        </x-td>

                        <x-td>
                            @if(!$product->inventory)
                                <div class="badge badge-light-danger">ناموجود</div>
                            @else
                                {{ $product->inventory ?? '-'}}
                            @endif
                        </x-td>

                        <x-td>
                            {{ $product->price_label }}
                        </x-td>

                        <x-td>
                            <div class="btn-group me-2" role="group" aria-label="First group">

                            @if($product->trashed())
                                <x-form method="POST" :action="route('admin.products.force-delete', $product)">
                                    <x-delete-button />
                                </x-form>

                                <x-form method="PUT" :action="route('admin.products.restore', $product)">
                                    <x-restore-button />
                                </x-form>
                            @else

                                <x-form method="DELETE" :action="route('admin.products.destroy', $product)">
                                    <x-delete-button />
                                </x-form>

                                <x-edit-button :href="route('admin.products.edit', ['product' => $product])"/>

                            @endif

                            </div>
                        </x-td>
                    </x-tr>

                @empty

                    <x-tr>
                        <x-td colspan="6">آیتمی برای نمایش وجود ندارد.</x-td>
                    </x-tr>

                @endforelse

            </x-table>
        </x-panel.card-body>

        <x-panel.card-footer>
           <x-panel.paginate :links="$products" />
        </x-panel.card-footer>

    </x-panel.card>

@endsection
