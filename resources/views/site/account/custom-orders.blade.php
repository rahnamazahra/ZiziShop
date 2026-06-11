@extends('layouts.site.master')
@section('title', 'سفارش‌های ویژه‌ی من')
@section('content')
<section class="pt-95 pb-95">
    <div class="container">
        <h3 class="mb-40">سفارش‌های ویژه‌ی من</h3>

        @forelse($orders as $order)
            @php
                $status = $order->status;
                $badge = [
                    'pending'  => ['#fff7e6', '#8a5a00', 'در انتظار بررسی'],
                    'approved' => ['#eaf2ff', '#1b4f9c', 'تأیید شد - در انتظار پرداخت'],
                    'rejected' => ['#fdecec', '#464387', 'رد شد'],
                    'paid'     => ['#e8f8ef', '#1f9d55', 'پرداخت شد - در حال تولید'],
                ][$status->value] ?? ['#f3f3f3', '#555', $status->value];
            @endphp

            <div style="border:1px solid #eee;border-radius:12px;padding:20px;margin-bottom:16px;">
                <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap:10px;">
                    <div>
                        <strong>{{ $order->product->name ?? 'محصول حذف‌شده' }}</strong>
                        <span style="color:#888;font-size:13px;"> — درخواست #{{ $order->id }}</span>
                    </div>
                    <span style="background:{{ $badge[0] }};color:{{ $badge[1] }};padding:5px 14px;border-radius:20px;font-size:13px;font-weight:700;">
                        {{ $badge[2] }}
                    </span>
                </div>

                <div style="color:#666;margin-top:10px;line-height:2;">
                    <div>تعداد: {{ $order->quantity }}</div>
                    <div>توضیحات: {{ $order->description }}</div>
                    <div>تاریخ ثبت: {{ gdate($order->created_at) }}</div>

                    @if($order->unit_price)
                        <div style="color:#111;font-weight:700;margin-top:6px;">
                            قیمت واحد: {{ number_format($order->unit_price) }} تومان —
                            مبلغ کل: {{ number_format($order->total) }} تومان
                        </div>
                    @endif

                    @if($order->admin_note)
                        <div style="margin-top:6px;background:#fafafa;border-radius:8px;padding:10px 12px;">
                            <span style="color:#999;">پیام پشتیبانی:</span> {{ $order->admin_note }}
                        </div>
                    @endif
                </div>

                @if($order->isPayable())
                    <a href="{{ route('custom.order.pay', $order) }}"
                       style="display:inline-block;margin-top:14px;background:#1f9d55;color:#fff;padding:11px 30px;border-radius:30px;font-weight:700;text-decoration:none;">
                        پرداخت {{ number_format($order->total) }} تومان
                    </a>
                @endif
            </div>
        @empty
            <p>هنوز سفارش ویژه‌ای ثبت نکرده‌اید. در صفحه‌ی محصولات ناموجود می‌توانید سفارش ویژه ثبت کنید.</p>
        @endforelse

        <div class="mt-30">
            {{ $orders->links() }}
        </div>
    </div>
</section>
@endsection
