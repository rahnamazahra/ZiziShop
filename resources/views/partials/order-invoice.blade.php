@php
    $itemsSubtotal   = $order->products->sum(fn ($p) => (int) $p->pivot->price * (int) $p->pivot->count);
    $paid            = (int) (optional($order->payment)->total ?? $order->total);
    $voucherDiscount = max(0, $itemsSubtotal - (int) $order->total);
    $walletUsed      = max(0, (int) $order->total - $paid);
    $isAdmin         = $isAdmin ?? false;
@endphp

<div class="gr-invoice" style="background:#fff;border:1px solid #eee;border-radius:12px;padding:28px;width:100%;">
    {{-- سربرگ --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;border-bottom:2px solid #343265;padding-bottom:16px;margin-bottom:20px;">
        <div>
            <h3 style="margin:0;color:#343265;font-weight:800;">گالری رهنما</h3>
            <div style="color:#888;font-size:13px;margin-top:4px;">فاکتور فروش</div>
        </div>
        <div style="text-align:left;font-size:13px;color:#555;line-height:2;">
            <div>شماره فاکتور: <strong>#{{ $order->id }}</strong></div>
            <div>تاریخ: {{ gdatetime($order->created_at) }}</div>
        </div>
    </div>

    {{-- مشتری و آدرس --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
        <div style="font-size:13px;line-height:2;">
            <div style="color:#999;">مشتری</div>
            <strong>{{ optional($order->user)->name ?? '—' }}</strong>
            <div dir="ltr" style="color:#555;">{{ optional($order->user)->mobile }}</div>
        </div>
        <div style="font-size:13px;line-height:2;">
            <div style="color:#999;">نشانی ارسال</div>
            <div style="color:#555;">{{ $order->address_text }}</div>
        </div>
    </div>

    {{-- اقلام --}}
    <table style="width:100%;border-collapse:collapse;font-size:13px;margin-bottom:18px;">
        <thead>
            <tr style="background:#faf3f5;color:#343265;">
                <th style="padding:10px;text-align:right;border:1px solid #f0e3e7;">محصول</th>
                <th style="padding:10px;border:1px solid #f0e3e7;">سایز / رنگ</th>
                <th style="padding:10px;border:1px solid #f0e3e7;">تعداد</th>
                <th style="padding:10px;border:1px solid #f0e3e7;">قیمت واحد</th>
                <th style="padding:10px;border:1px solid #f0e3e7;">جمع</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->products as $product)
                <tr>
                    <td style="padding:10px;border:1px solid #eee;">{{ $product->name }}</td>
                    <td style="padding:10px;border:1px solid #eee;text-align:center;">
                        @if($product->pivot->size_id || $product->pivot->color_id)
                            {{ $order->pivotSizeName($product) }} / {{ $order->pivotColorName($product) }}
                        @else — @endif
                    </td>
                    <td style="padding:10px;border:1px solid #eee;text-align:center;">{{ $product->pivot->count }}</td>
                    <td style="padding:10px;border:1px solid #eee;text-align:center;">{{ number_format($product->pivot->price) }}</td>
                    <td style="padding:10px;border:1px solid #eee;text-align:center;">{{ number_format($product->pivot->price * $product->pivot->count) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- جمع‌بندی --}}
    <div style="max-width:340px;margin-right:auto;font-size:14px;line-height:2.2;">
        <div style="display:flex;justify-content:space-between;"><span>جمع کل اقلام:</span><span>{{ number_format($itemsSubtotal) }} ت</span></div>
        @if($voucherDiscount > 0)
            <div style="display:flex;justify-content:space-between;color:#1f9d55;"><span>تخفیف کوپن:</span><span>− {{ number_format($voucherDiscount) }} ت</span></div>
        @endif
        @if($walletUsed > 0)
            <div style="display:flex;justify-content:space-between;color:#1f9d55;"><span>پرداخت از کیف پول:</span><span>− {{ number_format($walletUsed) }} ت</span></div>
        @endif
        <div style="display:flex;justify-content:space-between;"><span>هزینه ارسال:</span><span>{{ number_format($order->shipping_fee) }} ت</span></div>
        <div style="display:flex;justify-content:space-between;border-top:1px dashed #ccc;margin-top:6px;padding-top:6px;font-weight:800;color:#343265;font-size:16px;">
            <span>مبلغ پرداخت‌شده:</span><span>{{ number_format($paid) }} ت</span>
        </div>
    </div>

    {{-- پرداخت و رهگیری --}}
    <div style="margin-top:20px;border-top:1px solid #eee;padding-top:16px;font-size:13px;line-height:2;color:#555;">
        @if($order->payment)
            <div>درگاه پرداخت: {{ $order->payment->gateway }} — کد پیگیری: <span dir="ltr">{{ $order->payment->tracking_code }}</span></div>
        @endif

        @if($order->postal_tracking)
            <div style="margin-top:6px;background:#eef7ff;border:1px solid #cfe6ff;border-radius:8px;padding:10px 12px;">
                📦 کد رهگیری پستی: <strong dir="ltr">{{ $order->postal_tracking }}</strong>
                — <a href="https://tracking.post.ir/?id={{ $order->postal_tracking }}" target="_blank" rel="noopener" style="color:#527aba;">پیگیری مرسوله</a>
            </div>
        @endif
    </div>
</div>
