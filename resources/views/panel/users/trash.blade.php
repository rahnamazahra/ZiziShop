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

        <x-panel.card-body>
            <x-table.layout :headers="['ردیف', 'نام', 'شماره تلفن', 'تاریخ تولد', 'شهر', 'اقدامات']" :data="$users" :actions="[['route' => 'admin.users.restore','title' => 'بازنشانی','icon' => 'svg.restore'], ['route' => 'admin.users.delete-force','title' => 'حذف','icon' => 'svg.trash']]" />
        </x-panel.card-body>

        <x-panel.card-footer>
            <x-panel.paginate :links="$users" />
        </x-panel.card-footer>
    </x-panel.card>
@endsection
