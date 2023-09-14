
@extends('layouts.panel.master')

@section('title', 'محصولات')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard')]" title='محصولات' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>
                <x-panel.card-title>
                   <x-form.search :route="route('admin.products.index')" />
                </x-panel.card-title>

            <x-panel.card-toolbar>
                <x-form.btn-a :route="route('admin.products.create')" class="btn-sm btn-primary" label="ایجاد محصول جدید" />
            </x-panel.card-toolbar>
        </x-panel.card-header>

        <x-panel.card-body>
            <x-table.layout :headers="['ردیف', 'عنوان',  'اقدامات']" :data="$products" />
        </x-panel.card-body>

        <x-panel.card-footer>
        </x-panel.card-footer>
    </x-panel.card>
@endsection

