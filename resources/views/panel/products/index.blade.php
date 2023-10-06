@extends('layouts.panel.master')

@section('title', 'محصولات')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'محصولات' => route('admin.products.index')]" title='محصولات' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>

            <x-panel.card-title>
                <x-panel.search :action="route('admin.products.search')" />
            </x-panel.card-title>

            <x-panel.card-toolbar>

                <x-form.btn-a :href="route('admin.products.create')" class="btn-primary" title="ایجاد محصول جدید">
                    ایجاد محصول جدید
                </x-form.btn-a>

                <x-form.btn-a :href="route('admin.products.export')" class="btn-light-primary" title="Export Excel">
                    Export Excel
                    <x-svg.icon-svg icon="export" />
                </x-form.btn-a>

                <x-form.btn-a :href="route('admin.products.trash')" class="btn-light" title="سطل‌زباله">
                    <x-svg.icon-svg icon="delete" />
                </x-form.btn-a>

            </x-panel.card-toolbar>
        </x-panel.card-header>

        <x-panel.card-body>
            @php
                $actions = [
                        ['method' => 'GET', 'route' => 'admin.products.edit','title' => 'ویرایش','icon' => 'edit'],
                        ['method' => 'DELETE', 'route' => 'admin.products.delete','title' => 'حذف','icon' => 'close']
                    ];

                $headers = [
                    'ردیف'=>'id',
                    'نام'=>'name',
                ];
            @endphp

            <x-table.layout :headers="$headers" :data="$products" :actions="$actions"/>
        </x-panel.card-body>

        <x-panel.card-footer>
           <x-panel.paginate :links="$products" />
        </x-panel.card-footer>

    </x-panel.card>

@endsection
