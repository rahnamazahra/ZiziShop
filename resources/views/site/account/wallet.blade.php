@extends('layouts.site.lux')

@section('title', 'کیف پول من — گالری رهنما')

@section('content')
<div class="acc-page">
    <nav class="crumb">
        <a href="{{ url('/') }}">خانه</a>
        <span>/</span>
        <a href="{{ route('account.profile') }}">حساب کاربری</a>
        <span>/</span>
        <b>کیف پول</b>
    </nav>

    <h2 class="acc-title goldtext">کیف پول من</h2>

    <div class="wallet-card">
        <div class="wc-label">موجودی قابل استفاده</div>
        <div class="wc-amount">{{ fa_num(number_format($wallet->usableBalance())) }} <span>تومان</span></div>
        @if($wallet->expires_at && ! $wallet->isExpired())
            <div class="wc-exp">اعتبار تا تاریخ {{ fa_num(gdate($wallet->expires_at)) }}</div>
        @else
            <div class="wc-exp">با اولین خرید، کیف پول شما {{ fa_toman(\App\Models\Wallet::FIRST_CHARGE) }} شارژ می‌شود.</div>
        @endif
    </div>

    <div style="max-width:640px;margin-top:26px;">
        <h3 class="acc-title" style="font-size:24px;">چطور کار می‌کند؟</h3>
        <div class="notice">
            <b>✦</b>
            <span>بعد از هر <em>خرید موفق</em>، مبلغی به کیف پول شما اضافه می‌شود.</span>
        </div>
        <div class="notice">
            <b>✦</b>
            <span>بار اول <em>{{ fa_toman(\App\Models\Wallet::FIRST_CHARGE) }}</em> و هر خرید بعدی <em>{{ fa_toman(\App\Models\Wallet::STEP) }} بیشتر</em> از دفعه‌ی قبل.</span>
        </div>
        <div class="notice">
            <b>✦</b>
            <span>اعتبار کیف پول تا <em>۳ ماه</em> معتبر است و در خریدهای بعدی قابل استفاده است.</span>
        </div>
        <div class="notice">
            <b>✦</b>
            <span>اگر ۳ ماه خریدی نکنید، اعتبار صفر و دوباره از {{ fa_toman(\App\Models\Wallet::FIRST_CHARGE) }} شروع می‌شود.</span>
        </div>
    </div>
</div>
@endsection
