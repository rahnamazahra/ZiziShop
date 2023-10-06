@extends('layouts.panel.master')

@section('title', 'دسته‌بندی')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'دسته‌بندی' => route('admin.categories.index')]" title='دسته‌بندی' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>

            <x-panel.card-title>
                <x-panel.search :action="route('admin.categories.search')" />
            </x-panel.card-title>

            <x-panel.card-toolbar>

                <x-form.btn-a :href="route('admin.categories.create')" class="btn-primary" title="ایجاد دسته‌بندی جدید">
                    ایجاد دسته‌بندی جدید
                </x-form.btn-a>

                <x-form.btn-a :href="route('admin.categories.export')" class="btn-light-primary" title="Export Excel">
                    Export Excel
                    <x-svg.icon-svg icon="export" />
                </x-form.btn-a>

                <x-form.btn-a :href="route('admin.categories.trash')" class="btn-light" title="سطل‌زباله">
                    <x-svg.icon-svg icon="delete" />
                </x-form.btn-a>

            </x-panel.card-toolbar>
        </x-panel.card-header>

        <x-panel.card-body>
            @php
                $actions = [
                    ['method' => 'GET', 'route' => 'admin.categories.edit','title' => 'ویرایش','icon' => 'edit'],
                    ['method' => 'DELETE', 'route' => 'admin.categories.delete','title' => 'حذف','icon' => 'close']
                    ];

                $headers = [
                    'ردیف'=>'id',
                    'نام'=>'name',
                ];
            @endphp

            <x-table.layout :headers="$headers" :data="$categories" :actions="$actions"/>
        </x-panel.card-body>

        <x-panel.card-footer>
           <x-panel.paginate :links="$categories" />
        </x-panel.card-footer>

    </x-panel.card>


@endsection
