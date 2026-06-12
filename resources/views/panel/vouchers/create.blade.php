@extends('layouts.panel.master')

@section('title', 'ایجاد کوپن')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد' => route('admin.dashboard'), 'کوپن‌ها' => route('admin.vouchers.index'), 'ایجاد کوپن' => '#']" title='ایجاد کوپن جدید' />
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.vouchers.store') }}">
        @csrf
        <x-panel.card>
            <x-panel.card-header>
                <x-panel.card-title><x-panel.heading level="2">ایجاد کوپن جدید</x-panel.heading></x-panel.card-title>
            </x-panel.card-header>

            <x-panel.card-body>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label required">کد تخفیف</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
                        <x-form.input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>

                    <div class="col-md-3">
                        <label class="form-label required">نوع تخفیف</label>
                        <select name="discount_type" class="form-select" required>
                            <option value="percent" @selected(old('discount_type')==='percent')>درصدی</option>
                            <option value="amount" @selected(old('discount_type')==='amount')>مبلغی (تومان)</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label required">مقدار</label>
                        <input type="number" name="value" class="form-control" value="{{ old('value') }}" min="1" required>
                        <div class="text-muted fs-8">درصد (مثلاً ۲۰) یا مبلغ به تومان.</div>
                        <x-form.input-error :messages="$errors->get('value')" class="mt-2" />
                    </div>

                    {{-- دامنه‌ی کاربر --}}
                    <div class="col-md-6">
                        <label class="form-label required">برای کدام کاربران؟</label>
                        <select name="audience" id="audience" class="form-select" required onchange="document.getElementById('mobile-box').style.display = this.value==='user' ? 'block':'none';">
                            <option value="all" @selected(old('audience','all')==='all')>همه‌ی کاربران</option>
                            <option value="user" @selected(old('audience')==='user')>کاربر خاص (با شماره موبایل)</option>
                        </select>
                        <div id="mobile-box" class="mt-2" style="display:{{ old('audience')==='user' ? 'block':'none' }};">
                            <input type="text" name="mobile" class="form-control" placeholder="09xxxxxxxxx" value="{{ old('mobile') }}" maxlength="11">
                            <x-form.input-error :messages="$errors->get('mobile')" class="mt-2" />
                        </div>
                    </div>

                    {{-- دامنه‌ی محصول --}}
                    <div class="col-md-6">
                        <label class="form-label required">برای کدام محصولات؟</label>
                        <select name="product_scope" id="product_scope" class="form-select" required onchange="document.getElementById('product-box').style.display = this.value==='product' ? 'block':'none';">
                            <option value="all" @selected(old('product_scope','all')==='all')>همه‌ی محصولات</option>
                            <option value="product" @selected(old('product_scope')==='product')>محصول خاص</option>
                        </select>
                        <div id="product-box" class="mt-2" style="display:{{ old('product_scope')==='product' ? 'block':'none' }};">
                            <select name="product_id" class="form-select">
                                <option value="">— انتخاب محصول —</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}" @selected(old('product_id')==$p->id)>{{ $p->name }}</option>
                                @endforeach
                            </select>
                            <x-form.input-error :messages="$errors->get('product_id')" class="mt-2" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">تاریخ شروع (شمسی)</label>
                        <input type="text" name="start_date" class="form-control" value="{{ old('start_date') }}" data-jdp>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">تاریخ پایان (شمسی)</label>
                        <input type="text" name="end_date" class="form-control" value="{{ old('end_date') }}" data-jdp>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label required">تعداد دفعات قابل استفاده</label>
                        <input type="number" name="remaining" class="form-control" value="{{ old('remaining', 1) }}" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">توضیحات</label>
                        <input type="text" name="comment" class="form-control" value="{{ old('comment') }}">
                    </div>
                </div>
            </x-panel.card-body>

            <x-panel.card-footer>
                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                    <div class="text-muted fs-8 d-flex align-items-center gap-2">
                        <span>💡</span>
                        <span>پیامک ارسال نمی‌شود — پس از ثبت، از دکمه‌های <strong>«📨 پیامک»</strong> یا <strong>«🏷️ اعمال در سایت»</strong> در لیست کوپن‌ها استفاده کنید.</span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-light">لغو</a>
                        <button type="submit" class="btn btn-primary">ثبت کوپن</button>
                    </div>
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
