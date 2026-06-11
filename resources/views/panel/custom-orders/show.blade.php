@extends('layouts.panel.master')

@section('title', 'بررسی سفارش ویژه')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'سفارش‌های ویژه' => route('admin.custom-orders.index'), 'بررسی' => '#']" title='بررسی سفارش ویژه' />
@endsection

@section('content')
    <div class="row g-5">
        {{-- اطلاعات سفارش --}}
        <div class="col-lg-6">
            <x-panel.card>
                <x-panel.card-header>
                    <x-panel.card-title>
                        <x-panel.heading level="2">جزئیات درخواست #{{ $order->id }}</x-panel.heading>
                    </x-panel.card-title>
                </x-panel.card-header>
                <x-panel.card-body>
                    {{-- کارت محصول مورد سفارش --}}
                    @if($order->product)
                        <div class="d-flex align-items-center gap-4 mb-5 p-3 bg-light rounded">
                            <img src="{{ $order->product->poster_url }}" style="width:80px;height:80px;object-fit:cover;border-radius:8px;" alt="">
                            <div>
                                <a href="{{ route('admin.products.show', $order->product) }}" class="fw-bold text-gray-800 fs-5 d-block">{{ $order->product->name }}</a>
                                <span class="text-muted fs-7">کد محصول (SKU): {{ $order->product->sku ?: '—' }}</span><br>
                                <span class="text-muted fs-7">قیمت پایه: {{ number_format($order->product->price) }} تومان</span>
                            </div>
                        </div>
                    @endif

                    <table class="table table-row-dashed gy-3">
                        <tr><td class="fw-bold text-gray-600">نام مشتری</td><td>{{ $order->contact_name ?: ($order->user->name ?? 'مهمان') }}</td></tr>
                        <tr><td class="fw-bold text-gray-600">نوع کاربر</td><td>{{ $order->user_id ? 'کاربر ثبت‌نام‌شده' : 'مهمان' }}</td></tr>
                        <tr><td class="fw-bold text-gray-600">شماره تماس</td><td><a href="tel:{{ $order->contact_mobile }}" dir="ltr">{{ $order->contact_mobile }}</a></td></tr>
                        <tr><td class="fw-bold text-gray-600">تعداد</td><td>{{ $order->quantity }}</td></tr>
                        <tr><td class="fw-bold text-gray-600">توضیحات کاربر</td><td>{{ $order->description }}</td></tr>
                        <tr><td class="fw-bold text-gray-600">وضعیت</td><td><span class="badge {{ $order->status->badgeClass() }}">{{ $order->status->label() }}</span></td></tr>
                        @if($order->unit_price)
                            <tr><td class="fw-bold text-gray-600">قیمت واحد</td><td>{{ number_format($order->unit_price) }} تومان</td></tr>
                            <tr><td class="fw-bold text-gray-600">مبلغ کل</td><td class="fw-bold">{{ number_format($order->total) }} تومان</td></tr>
                        @endif
                        @if($order->admin_note)
                            <tr><td class="fw-bold text-gray-600">یادداشت</td><td>{{ $order->admin_note }}</td></tr>
                        @endif
                        @if($order->paid_at)
                            <tr><td class="fw-bold text-gray-600">پرداخت</td><td class="text-success">پرداخت‌شده در {{ gdatetime($order->paid_at) }}</td></tr>
                        @endif
                        <tr><td class="fw-bold text-gray-600">تاریخ ثبت</td><td>{{ gdatetime($order->created_at) }}</td></tr>
                    </table>

                    {{-- آدرس‌های کاربر ثبت‌نام‌شده --}}
                    @if($order->user && $order->user->addresses->isNotEmpty())
                        <h4 class="mt-6 mb-3 fs-6 fw-bold">آدرس‌های کاربر</h4>
                        @foreach($order->user->addresses as $address)
                            <div class="p-3 mb-2 border rounded fs-7">
                                <div><strong>گیرنده:</strong> {{ $address->receiver }} — <strong>موبایل:</strong> <span dir="ltr">{{ $address->mobile }}</span></div>
                                <div><strong>استان/شهر:</strong> {{ optional(optional($address->city)->province)->name }} / {{ optional($address->city)->name }} — <strong>کدپستی:</strong> {{ $address->postal_code }}</div>
                                <div><strong>نشانی:</strong> {{ $address->body }}</div>
                            </div>
                        @endforeach
                    @endif
                </x-panel.card-body>
            </x-panel.card>
        </div>

        {{-- اقدامات --}}
        <div class="col-lg-6">
            @if(in_array($order->status->value, ['pending', 'approved']))
                {{-- تأیید و قیمت‌گذاری --}}
                <x-panel.card class="mb-5">
                    <x-panel.card-header>
                        <x-panel.card-title>
                            <x-panel.heading level="2">تأیید و قیمت‌گذاری</x-panel.heading>
                        </x-panel.card-title>
                    </x-panel.card-header>
                    <x-panel.card-body>
                        <form method="POST" action="{{ route('admin.custom-orders.approve', $order) }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label required">قیمت واحد (تومان)</label>
                                <input type="number" name="unit_price" class="form-control" min="1000" value="{{ old('unit_price', $order->unit_price) }}" required>
                                <x-form.input-error :messages="$errors->get('unit_price')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <label class="form-label">یادداشت برای کاربر (اختیاری)</label>
                                <textarea name="admin_note" class="form-control" rows="3">{{ old('admin_note', $order->admin_note) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">تأیید و فعال‌سازی پرداخت</button>
                        </form>
                    </x-panel.card-body>
                </x-panel.card>

                {{-- رد سفارش --}}
                <x-panel.card>
                    <x-panel.card-header>
                        <x-panel.card-title>
                            <x-panel.heading level="2">رد سفارش</x-panel.heading>
                        </x-panel.card-title>
                    </x-panel.card-header>
                    <x-panel.card-body>
                        <form method="POST" action="{{ route('admin.custom-orders.reject', $order) }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label required">دلیل رد</label>
                                <textarea name="admin_note" class="form-control" rows="3" required>{{ old('admin_note') }}</textarea>
                                <x-form.input-error :messages="$errors->get('admin_note')" class="mt-2" />
                            </div>
                            <button type="submit" class="btn btn-light-danger">رد سفارش</button>
                        </form>
                    </x-panel.card-body>
                </x-panel.card>
            @else
                <x-panel.card>
                    <x-panel.card-body>
                        <div class="text-muted">این سفارش در وضعیت «{{ $order->status->label() }}» است و اقدام جدیدی لازم نیست.</div>
                    </x-panel.card-body>
                </x-panel.card>
            @endif
        </div>
    </div>
@endsection
