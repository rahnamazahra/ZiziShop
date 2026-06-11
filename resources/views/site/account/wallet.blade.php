@extends('layouts.site.master')
@section('title', 'کیف پول من')
@section('content')
<section class="pt-95 pb-95">
    <div class="container">
        <h3 class="mb-40">کیف پول من</h3>

        <div style="max-width:520px;border:1px solid #eee;border-radius:12px;padding:24px;background:linear-gradient(135deg,#343265,#010f1c);color:#fff;">
            <div style="font-size:14px;opacity:.85;">موجودی قابل استفاده</div>
            <div style="font-size:32px;font-weight:800;margin:6px 0;">{{ number_format($wallet->usableBalance()) }} <span style="font-size:16px;">تومان</span></div>
            @if($wallet->expires_at && ! $wallet->isExpired())
                <div style="font-size:13px;opacity:.85;">اعتبار تا تاریخ {{ gdate($wallet->expires_at) }}</div>
            @else
                <div style="font-size:13px;opacity:.85;">با اولین خرید، کیف پول شما {{ number_format(\App\Models\Wallet::FIRST_CHARGE) }} تومان شارژ می‌شود.</div>
            @endif
        </div>

        <div style="margin-top:24px;line-height:2.2;color:#444;max-width:680px;">
            <h5 class="mb-15">چطور کار می‌کند؟</h5>
            <ul style="padding-right:18px;">
                <li>بعد از هر <strong>خرید موفق</strong>، مبلغی به کیف پول شما اضافه می‌شود.</li>
                <li>بار اول <strong>{{ number_format(\App\Models\Wallet::FIRST_CHARGE) }} تومان</strong> و هر خرید بعدی <strong>{{ number_format(\App\Models\Wallet::STEP) }} تومان بیشتر</strong> از دفعه‌ی قبل.</li>
                <li>اعتبار کیف پول تا <strong>۳ ماه</strong> معتبر است و در خریدهای بعدی قابل استفاده است.</li>
                <li>اگر ۳ ماه خریدی نکنید، اعتبار صفر و دوباره از {{ number_format(\App\Models\Wallet::FIRST_CHARGE) }} تومان شروع می‌شود.</li>
            </ul>
        </div>
    </div>
</section>
@endsection
