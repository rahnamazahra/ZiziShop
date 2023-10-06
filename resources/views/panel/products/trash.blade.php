@extends('layouts.panel.master')

@section('title', 'کاربران')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'کاربران' => route('admin.users.index'), 'سطل زباله' => route('admin.users.index')]" title='کاربران' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>
            <x-panel.card-title>
            </x-panel.card-title>

            <x-panel.card-toolbar>
                <x-form.btn-a :route="route('admin.users.create')" class="btn-primary" title="حذف همه">
                    حذف همه
                </x-form.btn-a>
            </x-panel.card-toolbar>
        </x-panel.card-header>

               @php

                $headers = [
                    'ردیف'=>'id',
                    'نام'=>'name',
                    'شماره تلفن' => 'mobile',
                    'تاریخ تولد' => 'birthday',
                    'استان' => 'province_id',
                    'شهر' => 'city_id',
                ];

            @endphp

        <x-panel.card-body>
            <x-table.layout :headers="$headers" :data="$users" :actions="[['method' => 'GET', 'route' => 'admin.users.restore', 'title' => 'بازنشانی', 'icon' => 'restore'], ['method' => 'GET', 'route' => 'admin.users.delete-force', 'title' => 'حذف', 'icon' => 'delete']]" />
        </x-panel.card-body>

        <x-panel.card-footer>
            <x-panel.paginate :links="$users" />
        </x-panel.card-footer>
    </x-panel.card>
@endsection
