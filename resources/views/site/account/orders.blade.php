@extends('layouts.site.master')
@section('title', 'سفارش‌های من')
@section('content')
<section class="pt-95 pb-95">
    <div class="container">
        <h3 class="mb-40">سفارش‌های من</h3>
        @forelse($orders as $order)
            <div style="border:1px solid #eee;border-radius:10px;padding:18px;margin-bottom:14px;">
                <div class="d-flex justify-content-between align-items-center mb-10" style="gap:10px;flex-wrap:wrap;">
                    <span><strong>سفارش #{{ $order->id }}</strong></span>
                    <span>{{ number_format($order->total) }} تومان</span>
                </div>
                <div style="color:#666;">تاریخ ثبت: {{ gdate($order->created_at) }}</div>
                @if($order->postal_tracking)
                    <div style="color:#527aba;margin-top:4px;">📦 کد رهگیری پستی: <strong dir="ltr">{{ $order->postal_tracking }}</strong></div>
                @endif
                <a href="{{ route('account.orders.show', $order) }}"
                   style="display:inline-block;margin-top:12px;background:#343265;color:#fff;padding:8px 22px;border-radius:24px;font-size:13px;font-weight:700;text-decoration:none;">
                    مشاهده فاکتور
                </a>
            </div>
        @empty
            <p>هنوز سفارشی ثبت نکرده‌اید.</p>
        @endforelse
    </div>
</section>
@endsection
