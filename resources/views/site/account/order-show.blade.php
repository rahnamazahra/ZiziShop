@extends('layouts.site.master')
@section('title', 'فاکتور سفارش #' . $order->id)
@section('content')
<section class="pt-95 pb-95">
    <div class="container">
        @include('partials.order-invoice', ['order' => $order])
        <div class="text-center mt-4">
            <a href="{{ route('account.orders') }}" style="color:#343265;font-weight:700;">‹ بازگشت به سفارش‌ها</a>
        </div>
    </div>
</section>
@endsection
