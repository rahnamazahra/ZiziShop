@extends('layouts.panel.master')

@section('title', 'دسته‌بندی')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'دسته‌بندی' => route('admin.categories.index')]" title='دسته‌بندی' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>

            <x-panel.card-title>
                <x-panel.search :action="route('admin.categories.index', ['search'])" />
            </x-panel.card-title>

            <x-panel.card-toolbar>

                <x-form.btn-a :href="route('admin.categories.create')" class="btn-primary" title="ایجاد دسته‌بندی جدید">
                    ایجاد دسته‌بندی جدید
                </x-form.btn-a>


                <form method="POST" action="{{ route('admin.categories.export') }}">
                    @csrf

                    <input type="hidden" name="search" value="{{ request()->has('search') ? request()->query('search') : '' }}">

                    <x-form.btn class="btn-light-primary" title="expoert Excel">
                        Export Excel
                        <x-svg.icon-svg icon="export" />
                    </x-form.btn>
                </form>

                @if (request()->has('trashed'))
                    <x-form.btn-a :href="route('admin.categories.index')" class="btn-light" title="برگشت">
                        <x-svg.icon-svg icon="back" />
                    </x-form.btn-a>
                @else
                    <x-form.btn-a :href="route('admin.categories.index', ['trashed'])" class="btn-light" title="سطل‌زباله">
                        <x-svg.icon-svg icon="delete" />
                    </x-form.btn-a>
                @endif

            </x-panel.card-toolbar>
        </x-panel.card-header>

        <x-panel.card-body>
            <x-table>
                <x-tr>
                    <x-th></x-th>
                    <x-th>اقدامات</x-th>
                </x-tr>


                @forelse ($categories as $category)

                    <x-tr>
                        <x-td>
                            <div class="d-flex align-items-center">

                                <span class="symbol symbol-50px">
                                    <span class="symbol-label" style="background-image:url('{{ $category->image_url }}');"></span>
                                </span>

                                <div class="ms-5">
                                    <span class="text-gray-800 fs-4 fw-bolder" data-kt-ecommerce-product-filter="product_name">{{ $category->name ?? '-' }}</span>
                                </div>
                            </div>
                        </x-td>

                        <x-td>

                            <div class="btn-group me-2" role="group" aria-label="First group">

                             @if($category->trashed())
                                <x-form method="POST" :action="route('admin.categories.force-delete', $category)">
                                    <x-delete-button />
                                </x-form>

                                <x-form method="PUT" :action="route('admin.categories.restore', $category)">
                                    <x-restore-button />
                                </x-form>
                            @else

                                <x-form method="DELETE" :action="route('admin.categories.destroy', $category)">
                                    <x-delete-button />
                                </x-form>

                                <x-edit-button :href="route('admin.categories.edit', $category)"/>

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
           <x-panel.paginate :links="$categories" />
        </x-panel.card-footer>

    </x-panel.card>


@endsection
