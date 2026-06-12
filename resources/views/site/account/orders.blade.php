@extends('layouts.site.lux')

@section('title', 'سفارش‌های من — گالری رهنما')

@section('content')
<div class="acc-page">
    <nav class="crumb">
        <a href="{{ url('/') }}">خانه</a>
        <span>/</span>
        <a href="{{ route('account.profile') }}">حساب کاربری</a>
        <span>/</span>
        <b>سفارش‌های من</b>
    </nav>

    <h2 class="acc-title goldtext">سفارش‌های من</h2>

    @forelse($orders as $order)
        <div class="acc-card" style="max-width:760px;">
            <div class="acc-card-head">
                <strong>سفارش <span class="muted">#{{ fa_num($order->id) }}</span></strong>
                <span style="color:var(--gold);font-size:14px;">{{ fa_toman($order->total) }}</span>
            </div>
            <div class="acc-card-body">
                <div>تاریخ ثبت: {{ fa_num(gdate($order->created_at)) }}</div>
                @if($order->postal_tracking)
                    <div>📦 کد رهگیری پستی: <strong style="direction:ltr;display:inline-block;">{{ $order->postal_tracking }}</strong></div>
                @endif
            </div>
            <a href="{{ route('account.orders.show', $order) }}" class="buybtn">مشاهده فاکتور</a>
        </div>
    @empty
        <p class="acc-empty">هنوز سفارشی ثبت نکرده‌اید.</p>
    @endforelse
</div>
@endsection
