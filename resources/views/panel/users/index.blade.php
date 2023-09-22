@extends('layouts.panel.master')

@section('title', 'کاربران')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'کاربران' => route('admin.users.index')]" title='کاربران' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>
            <x-panel.card-title>
                <x-form.search :route="route('admin.users.search')" />
                <x-form.btn  type="button" class="btn-outline btn-outline-light btn-active-light" title="فیلتر" data-bs-toggle="collapse" data-bs-target="#filter_search">
                    <x-svg.icon-svg icon='svg.filter' />
                </x-form.btn>
            </x-panel.card-title>

            <x-panel.card-toolbar>

                <x-form.btn-a :route="route('admin.users.export-users')" class="btn-outline btn-outline-success btn-active-success" title="خروجی Excel">
                    خروجی‌ اکسل
                </x-form.btn-a>

                <x-form.btn-a :route="route('admin.users.create')" class="btn-primary" title="ایجاد کاربر جدید">
                    ایجاد کاربر جدید
                </x-form.btn-a>

                <x-form.btn-a :route="route('admin.users.trash')" class="btn-warning" title="سطل‌زباله">
                    <x-svg.icon-svg icon="svg.trash" />
                </x-form.btn-a>
            </x-panel.card-toolbar>
        </x-panel.card-header>

        <x-panel.card-body>
             <div id="filter_search" class="flex collapse">
                <form method="GET" action="{{ route('admin.users.search') }}" class="mx-auto w-100 fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="row mb-8">
                        <div class="col-md-2 fv-row">
                            <div class="d-flex align-items-center fw-bolder" data-select2-id="select2-data-122-u471">
                                <div class="text-gray-400 fs-7 me-2">شهر</div>
                                <select name="gender_item" id="gender_item" class="form-select form-select-transparent text-graY-800 fs-base lh-1 fw-bolder py-0 ps-3 w-auto select2-hidden-accessible" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px" data-placeholder="لطفا انتخاب کنید" tabindex="-1" aria-hidden="true">
                                    <option value="all" @if (request()->query('city_item') == 'all') selected @endif>همه</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"> {{ $city->title }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 fv-row">
                            <div class="d-flex align-items-center fw-bolder" data-select2-id="select2-data-122-u471">
                                <div class="text-gray-400 fs-7 me-2">استان</div>
                                <select name="province_item" id="province_item" class="form-select form-select-transparent text-graY-800 fs-base lh-1 fw-bolder py-0 ps-3 w-auto select2-hidden-accessible" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px" data-placeholder="همه" tabindex="-1" aria-hidden="true">
                                    <option value="all" @if (request()->query('province_item') == 'all') selected @endif>همه</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"> {{ $province->title }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="جست‌وجو">جست‌و‌جو</button>
                        </div>
                        <div class="col-md-1">
                            <x-panel.link route="{{ route('admin.users.index') }}" id="btn_remove_filter" title="حذف فیلتر">
                                حذف فیلتر
                            </x-panel.link>
                        </div>
                    </div>
                </form>
            </div>
            @php
                $headers = [
                    'ردیف'=>'id',
                    'نام'=>'name'
                ];
            @endphp
            <x-table.layout :headers="$headers" :data="$users" :actions="[['route' => 'admin.users.edit','title' => 'ویرایش','icon' => 'svg.edit'], ['route' => 'admin.users.delete','title' => 'حذف','icon' => 'svg.trash']]" />
        </x-panel.card-body>

        <x-panel.card-footer>
           <x-panel.paginate :links="$users" />
        </x-panel.card-footer>
    </x-panel.card>
@endsection
