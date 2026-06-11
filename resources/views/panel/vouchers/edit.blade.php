@extends('layouts.panel.master')

@section('title', 'ویرایش کوپن')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد' => route('admin.dashboard'), 'کوپن‌ها' => route('admin.vouchers.index'), 'ویرایش' => '#']" title='ویرایش کوپن' />
@endsection

@php
    $discountType = $voucher->amount ? 'amount' : 'percent';
    $value        = $voucher->amount ?: $voucher->discount_percent;
    $audience     = $voucher->user_id ? 'user' : 'all';
    $productScope = $voucher->product_id ? 'product' : 'all';
@endphp

@section('content')
    <form method="POST" action="{{ route('admin.vouchers.update', $voucher) }}">
        @csrf
        @method('PUT')
        <x-panel.card>
            <x-panel.card-header>
                <x-panel.card-title><x-panel.heading level="2">ویرایش کوپن</x-panel.heading></x-panel.card-title>
            </x-panel.card-header>

            <x-panel.card-body>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label required">کد تخفیف</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $voucher->code) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label required">نوع تخفیف</label>
                        <select name="discount_type" class="form-select" required>
                            <option value="percent" @selected(old('discount_type', $discountType)==='percent')>درصدی</option>
                            <option value="amount" @selected(old('discount_type', $discountType)==='amount')>مبلغی (تومان)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label required">مقدار</label>
                        <input type="number" name="value" class="form-control" value="{{ old('value', $value) }}" min="1" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label required">برای کدام کاربران؟</label>
                        <select name="audience" class="form-select" required onchange="document.getElementById('mobile-box').style.display = this.value==='user' ? 'block':'none';">
                            <option value="all" @selected(old('audience', $audience)==='all')>همه‌ی کاربران</option>
                            <option value="user" @selected(old('audience', $audience)==='user')>کاربر خاص</option>
                        </select>
                        <div id="mobile-box" class="mt-2" style="display:{{ $audience==='user' ? 'block':'none' }};">
                            <input type="text" name="mobile" class="form-control" value="{{ old('mobile', optional($voucher->user)->mobile) }}" maxlength="11">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label required">برای کدام محصولات؟</label>
                        <select name="product_scope" class="form-select" required onchange="document.getElementById('product-box').style.display = this.value==='product' ? 'block':'none';">
                            <option value="all" @selected(old('product_scope', $productScope)==='all')>همه‌ی محصولات</option>
                            <option value="product" @selected(old('product_scope', $productScope)==='product')>محصول خاص</option>
                        </select>
                        <div id="product-box" class="mt-2" style="display:{{ $productScope==='product' ? 'block':'none' }};">
                            <select name="product_id" class="form-select">
                                <option value="">— انتخاب محصول —</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}" @selected(old('product_id', $voucher->product_id)==$p->id)>{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">تاریخ شروع</label>
                        <input type="text" name="start_date" class="form-control" value="{{ old('start_date', $voucher->start_date) }}" data-jdp>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">تاریخ پایان</label>
                        <input type="text" name="end_date" class="form-control" value="{{ old('end_date', $voucher->end_date) }}" data-jdp>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label required">تعداد قابل استفاده</label>
                        <input type="number" name="remaining" class="form-control" value="{{ old('remaining', $voucher->remaining) }}" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">توضیحات</label>
                        <input type="text" name="comment" class="form-control" value="{{ old('comment', $voucher->comment) }}">
                    </div>
                </div>
            </x-panel.card-body>

            <x-panel.card-footer>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-light">لغو</a>
                    <button type="submit" class="btn btn-primary">ذخیره</button>
                </div>
            </x-panel.card-footer>
        </x-panel.card>
    </form>
@endsection

@section('custom-scripts')
    <script>
        if (typeof jalaliDatepicker !== 'undefined') { jalaliDatepicker.startWatch(); }
    </script>
@endsection
