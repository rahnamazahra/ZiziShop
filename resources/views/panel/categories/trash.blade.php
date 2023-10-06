@extends('layouts.panel.master')

@section('title', 'دسته‌بندی')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'دسته‌بندی' => route('admin.categories.index'), 'سطل زباله' => route('admin.categories.index')]" title='دسته‌بندی' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>

            <x-panel.card-title />

            <x-panel.card-toolbar>
                <x-form.btn-a :route="route('admin.categories.create')" class="btn-primary" title="حذف همه">
                    حذف همه
                </x-form.btn-a>
            </x-panel.card-toolbar>

        </x-panel.card-header>

        @php

            $headers = [
                'ردیف'=>'id',
                'نام'=>'name',
            ];

        @endphp

        <x-panel.card-body>
            <x-table.layout :headers="$headers" :data="$categories" :actions="[['method' => 'GET', 'route' => 'admin.categories.restore', 'title' => 'بازنشانی', 'icon' => 'restore'], ['method' => 'GET', 'route' => 'admin.categories.delete-force', 'title' => 'حذف', 'icon' => 'delete']]" />
        </x-panel.card-body>

        <x-panel.card-footer>
            <x-panel.paginate :links="$categories" />
        </x-panel.card-footer>
        
    </x-panel.card>
@endsection
