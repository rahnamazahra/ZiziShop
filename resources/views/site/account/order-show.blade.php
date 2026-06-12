@extends('layouts.site.lux')

@section('title', 'فاکتور سفارش #' . $order->id . ' — گالری رهنما')

@section('content')
<div class="acc-page">
    <nav class="crumb">
        <a href="{{ url('/') }}">خانه</a>
        <span>/</span>
        <a href="{{ route('account.orders') }}">سفارش‌های من</a>
        <span>/</span>
        <b>فاکتور #{{ fa_num($order->id) }}</b>
    </nav>

    <div class="invoice-wrap">
        @include('partials.order-invoice', ['order' => $order])
        <div class="invoice-back">
            <a href="{{ route('account.orders') }}">‹ بازگشت به سفارش‌ها</a>
        </div>
    </div>
</div>
@endsection
