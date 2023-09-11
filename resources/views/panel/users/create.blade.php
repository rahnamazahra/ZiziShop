@extends('layouts.admin.master')

@section('title', 'کاربران')

@section('breadcrumb')
    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">ایجاد کاربر</h1>
    <span class="h-20px border-gray-300 border-start mx-4"></span>
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">داشبورد</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-muted">
            <a href="{{ route('admin.users.index') }}" class="text-muted text-hover-primary">کاربران</a>
        </li>
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-300 w-5px h-2px"></span>
        </li>
        <li class="breadcrumb-item text-dark">ایجاد کاربر</li>
    </ul>
@endsection

@section('content')
    <div class="card shadow-sm">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="card-header">
                <div class="card-title">ایجاد کاربر</div>
            </div>
            <div class="card-body">
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label for="name" class="required form-label">نام</label>
                        <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name') }}" />
                    </div>
                </div>
                <div class="col-md-6 fv-row">
                    <label for="phone" class="required form-label">شماره موبایل</label>
                    <input type="text" class="form-control form-control-solid input-just-number" id="mobile" name="mobile" value="{{ old('mobile') }}"/>
                </div>
                <div class="col-md-6 fv-row">
                    <label for="birthday" class="required form-label">تاریخ تولد</label>
                    <input type="text" class="form-control form-control-solid" data-jdp data-jdp-min-date="today" id="birthday" name="birthday" value="{{ old('birthday') }}"/>
                </div>
                <div class="col-md-6 fv-row">
                    <label for="province_id" class="required form-label">استان</label>
                    <select class="form-select form-select-solid" id="province_id" name="province_id" onchange="getCities(this.value)" data-control="select2" data-allow-clear="true" data-placeholder="استان را انتخاب کنید">
                        <option></option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}" @selected(old('province_id') == $province->id)>{{ $province->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 fv-row">
                    <label for="cities_list" class="required form-label">شهر</label>
                    <select class="form-select form-select-solid" id="cities_list" name="city_id" data-control="select2" data-allow-clear="true" data-placeholder="شهر را انتخاب کنید" disabled>
                        <option></option>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.users.index') }}" id="add_permission_form_cancel" class="btn btn-light me-3">لغو</a>
                    <button type="submit" id="add_permission_form_submit" class="btn btn-primary">
                        <span class="indicator-label">ثبت</span>
                        <span class="indicator-progress">لطفا چند لحظه صبر کنید ...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
