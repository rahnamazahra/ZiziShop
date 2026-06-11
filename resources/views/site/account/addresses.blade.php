@extends('layouts.site.master')
@section('title', 'آدرس‌های من')
@section('content')
<section class="pt-95 pb-95">
    <div class="container">
        <h3 class="mb-40">آدرس‌های من</h3>
        @forelse($addresses as $address)
            <div style="border:1px solid #eee;border-radius:10px;padding:18px;margin-bottom:14px;">
                <div><strong>گیرنده:</strong> {{ $address->receiver }} — {{ $address->mobile }}</div>
                <div><strong>کد ملی:</strong> {{ $address->national_code }} | <strong>کد پستی:</strong> {{ $address->postal_code }}</div>
                <div><strong>استان/شهر:</strong> {{ optional(optional($address->city)->province)->name }} / {{ optional($address->city)->name }}</div>
                <div><strong>آدرس:</strong> {{ $address->body }}</div>
            </div>
        @empty
            <p>هنوز آدرسی ثبت نکرده‌اید.</p>
        @endforelse
    </div>
</section>
@endsection
