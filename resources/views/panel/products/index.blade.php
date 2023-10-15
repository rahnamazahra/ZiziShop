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
            </x-panel.card-title>

            <x-panel.card-toolbar>

                <x-form.btn-a :href="route('admin.products.create')" class="btn-primary" title="ایجاد محصول جدید">
                    ایجاد محصول جدید
                </x-form.btn-a>

                <x-form.btn-a :href="route('admin.products.export')" class="btn-light-primary" title="Export Excel">
                    Export Excel
                    <x-svg.icon-svg icon="export" />
                </x-form.btn-a>

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
                    <x-th></x-th>
                    <x-th>اقدامات</x-th>
                </x-tr>


                @forelse ($products as $product)

                    <x-tr>
                        <x-td>{{ $product->id ?? '-' }}</x-td>
                        <x-td>
                            <div class="d-flex align-items-center">

                                <span class="symbol symbol-50px">
                                    <span class="symbol-label" style="background-image:url('{{ $product->image_url }}');"></span>
                                </span>

                                <div class="ms-5">
                                    <span class="text-gray-800 fs-5 fw-bolder" data-kt-ecommerce-product-filter="product_name">{{ $product->name ?? '-' }}</span>
                                </div>
                            </div>
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

                                <x-edit-button :href="route('admin.products.edit', $product)"/>

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
