@extends('layouts.site.lux')

@section('title', 'سفارش‌های ویژه‌ی من — گالری رهنما')

@section('content')
<div class="acc-page">
    <nav class="crumb">
        <a href="{{ url('/') }}">خانه</a>
        <span>/</span>
        <a href="{{ route('account.profile') }}">حساب کاربری</a>
        <span>/</span>
        <b>سفارش‌های ویژه</b>
    </nav>

    <h2 class="acc-title goldtext">سفارش‌های ویژه‌ی من</h2>

    @forelse($orders as $order)
        @php
            $st = $order->status->value;
            $label = [
                'pending'  => 'در انتظار بررسی',
                'approved' => 'تأیید شد — در انتظار پرداخت',
                'rejected' => 'رد شد',
                'paid'     => 'پرداخت شد — در حال آماده‌سازی',
            ][$st] ?? $st;
        @endphp
        <div class="acc-card" style="max-width:760px;">
            <div class="acc-card-head">
                <strong>{{ $order->product->name ?? 'محصول حذف‌شده' }} <span class="muted">درخواست #{{ fa_num($order->id) }}</span></strong>
                <span class="st-chip st-{{ $st }}">{{ $label }}</span>
            </div>
            <div class="acc-card-body">
                <div>تعداد: {{ fa_num($order->quantity) }}</div>
                <div>توضیحات: {{ $order->description }}</div>
                <div>تاریخ ثبت: {{ fa_num(gdate($order->created_at)) }}</div>
                @if($order->unit_price)
                    <div class="price">قیمت واحد: {{ fa_toman($order->unit_price) }} — مبلغ کل: {{ fa_toman($order->total) }}</div>
                @endif
                @if($order->admin_note)
                    <div class="acc-card-note">
                        <span style="color:var(--ink-3);">{{ $st === 'rejected' ? 'دلیل رد شدن' : 'پیام پشتیبانی' }}:</span>
                        {{ $order->admin_note }}
                    </div>
                @endif
                @if($order->isPaid() && $order->order_id)
                    <div class="acc-card-note" style="color:var(--gold-2);margin-top:6px;">
                        ✓ سفارش این محصول در حال آماده‌سازی است.
                        <a href="{{ route('account.orders.show', $order->order_id) }}" style="color:var(--gold);text-decoration:underline;">
                            مشاهده و پیگیری سفارش ›
                        </a>
                    </div>
                @endif
            </div>
            @if($order->isPayable())
                <a href="{{ route('custom.order.pay', $order) }}" class="buybtn">پرداخت {{ fa_toman($order->total) }}</a>
            @endif
        </div>
    @empty
        <p class="acc-empty">هنوز سفارش ویژه‌ای ثبت نکرده‌اید. در صفحه‌ی هر محصول (چه موجود چه ناموجود) می‌توانید سفارش ویژه ثبت کنید.</p>
    @endforelse

    @if($orders->hasPages())
        <div class="lux-pagination">
            @if($orders->onFirstPage())
                <span class="disabled">قبلی</span>
            @else
                <a href="{{ $orders->previousPageUrl() }}">قبلی</a>
            @endif
            <span>صفحه {{ fa_num($orders->currentPage()) }} از {{ fa_num($orders->lastPage()) }}</span>
            @if($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() }}">بعدی</a>
            @else
                <span class="disabled">بعدی</span>
            @endif
        </div>
    @endif
</div>
@endsection
