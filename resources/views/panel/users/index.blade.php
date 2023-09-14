@extends('layouts.panel.master')

@section('title', 'کاربران')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'کاربران' => route('admin.users.index')]" title='کاربران' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>
            <x-panel.card-title>
                <x-form.search :route="route('admin.users.index')" />
            </x-panel.card-title>

            <x-panel.card-toolbar>
                <x-form.btn-a :route="route('admin.users.create')" class="btn-sm btn-primary" label="ایجاد کاربر جدید" />
            </x-panel.card-toolbar>
        </x-panel.card-header>

        <x-panel.card-body>
            <x-table.layout :headers="['ردیف', 'نام', 'شماره تلفن', 'تاریخ تولد', 'شهر', 'اقدامات']" :data="$users" />
        </x-panel.card-body>

        <x-panel.card-footer>
        </x-panel.card-footer>
    </x-panel.card>
@endsection
