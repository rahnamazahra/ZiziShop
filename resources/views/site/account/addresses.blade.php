@extends('layouts.site.lux')

@section('title', 'آدرس‌های من — گالری رهنما')

@section('content')
<div class="acc-page">
    <nav class="crumb">
        <a href="{{ url('/') }}">خانه</a>
        <span>/</span>
        <a href="{{ route('account.profile') }}">حساب کاربری</a>
        <span>/</span>
        <b>آدرس‌های من</b>
    </nav>

    <h2 class="acc-title goldtext">آدرس‌های من</h2>

    @forelse($addresses as $address)
        <div class="acc-card" style="max-width:760px;">
            <div class="acc-card-head">
                <strong>{{ $address->receiver }}</strong>
                <span class="muted" style="direction:ltr;">{{ fa_num($address->mobile) }}</span>
            </div>
            <div class="acc-card-body">
                <div>کد ملی: {{ fa_num($address->national_code) }} — کد پستی: {{ fa_num($address->postal_code) }}</div>
                <div>{{ optional(optional($address->city)->province)->name }} / {{ optional($address->city)->name }}</div>
                <div>{{ $address->body }}</div>
            </div>
        </div>
    @empty
        <p class="acc-empty">هنوز آدرسی ثبت نکرده‌اید.</p>
    @endforelse

    <p class="acc-hint">برای افزودن آدرس جدید به <a href="{{ route('account.profile') }}#pane-addresses" style="color:var(--gold);">حساب کاربری ← آدرس‌ها</a> بروید.</p>
</div>
@endsection
