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

            <x-table>
                <x-tr>
                    <x-th>ردیف</x-th>
                    <x-th>محصول</x-th>
                    <x-th>امتیاز</x-th>
                    <x-th>وضعیت</x-th>
                    <x-th>SKU</x-th>
                    <x-th>بارکد</x-th>
                    <x-th>تعداد</x-th>
                    <x-th>قیمت</x-th>
                    <x-th>اقدامات</x-th>
                </x-tr>


                @forelse ($products as $product)

                    <x-tr>
                        <x-td>{{ $loop->iteration }}</x-td>
                        <x-td>
                            <div class="d-flex align-items-center">

                                <a href="" class="symbol symbol-50px">
                                    <span class="symbol-label" style="background-image:url('{{ $product->poster_url }}');"></span>
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

                                <x-detail-button :href="route('admin.products.show', $product)"/>

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
