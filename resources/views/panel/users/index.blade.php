@extends('layouts.panel.master')

@section('title', 'کاربران')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'کاربران' => route('admin.users.index')]" title='کاربران' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>
            <x-panel.card-title>

                <x-panel.search :action="route('admin.users.search')" />

                <x-form.btn type="button" class="btn-outline btn-outline-light btn-active-light" title="فیلتر" data-bs-toggle="collapse" data-bs-target="#filter_search">
                    <x-svg.icon-svg icon='filter' />
                </x-form.btn>

            </x-panel.card-title>

            <x-panel.card-toolbar>

                <x-form.btn-a href="route('admin.users.create')" class="btn-primary" title="ایجاد کاربر جدید">
                    ایجاد کاربر جدید
                </x-form.btn-a>

                 <x-form.btn-a :href="route('admin.users.export')" class="btn-light-primary" title="Export Excel">
                    Export Excel
                    <x-svg.icon-svg icon="export" />
                </x-form.btn-a>

                <x-form.btn-a href="route('admin.users.trash')" class="btn-light" title="سطل‌زباله">
                    <x-svg.icon-svg icon="delete" />
                </x-form.btn-a>

            </x-panel.card-toolbar>

        </x-panel.card-header>

        <x-panel.card-body>

            <x-panel.div-section id="filter_search" class="flex collapse">
                <x-form.layout method="GET" action="route('admin.users.search')" class="mx-auto w-100 fv-plugins-bootstrap5 fv-plugins-framework">
                    <x-panel.div-section class="row mb-8">

                        <x-panel.div-section class="col-md-2 fv-row">
                            <x-panel.div-section class="d-flex align-items-center fw-bolder" data-select2-id="select2-data-122-u471">
                                <x-panel.div-section class="text-gray-400 fs-7 me-2">شهر</x-panel.div-section>

                                <select name="gender_item" id="gender_item" class="form-select form-select-transparent text-graY-800 fs-base lh-1 fw-bolder py-0 ps-3 w-auto select2-hidden-accessible" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px" data-placeholder="لطفا انتخاب کنید" tabindex="-1" aria-hidden="true">
                                    <option value="all" @if (request()->query('city_item') == 'all') selected @endif>همه</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"> {{ $city->title }} </option>
                                    @endforeach
                                </select>

                            </x-panel.div-section>
                        </x-panel.div-section>

                        <x-panel.div-section class="col-md-2 fv-row">
                            <x-panel.div-section class="d-flex align-items-center fw-bolder" data-select2-id="select2-data-122-u471">
                                <x-panel.div-section class="text-gray-400 fs-7 me-2">استان</x-panel.div-section>

                                <select name="province_item" id="province_item" class="form-select form-select-transparent text-graY-800 fs-base lh-1 fw-bolder py-0 ps-3 w-auto select2-hidden-accessible" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px" data-placeholder="همه" tabindex="-1" aria-hidden="true">
                                    <option value="all" @if (request()->query('province_item') == 'all') selected @endif>همه</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"> {{ $province->title }} </option>
                                    @endforeach
                                </select>

                            </x-panel.div-section>
                        </x-panel.div-section>

                        <x-panel.div-section class="col-md-1">
                            <x-form.btn type="submit" class="btn btn-sm btn-primary" title="جست‌وجو">جست‌و‌جو</x-form.btn>
                        </x-panel.div-section>

                        <x-panel.div-section class="col-md-1">
                           <a href="route('admin.users.index')" id="btn_remove_filter">
                                حذف فیلتر
                           </a>
                        </x-panel.div-section>

                    </x-panel.div-section>
                </x-form.layout>
            </x-panel.div-section>

            @php
                $actions = [
                    ['method' => 'PATCH', 'route' => 'admin.users.edit','title' => 'ویرایش','icon' => 'edit'],
                    ['method' => 'DELETE', 'route' => 'admin.users.delete','title' => 'حذف','icon' => 'close']
                    ];

                $headers = [
                    'ردیف'=>'id',
                    'نام'=>'name',
                    'شماره تلفن' => 'mobile',
                    'تاریخ تولد' => 'birthday',
                    'استان' => 'province_id',
                    'شهر' => 'city_id',
                ];
            @endphp

            <x-table.layout :headers="$headers" :data="$users" :actions="$actions" />

        </x-panel.card-body>

        <x-panel.card-footer>
           <x-panel.paginate :links="$users" />
        </x-panel.card-footer>

    </x-panel.card>
@endsection
