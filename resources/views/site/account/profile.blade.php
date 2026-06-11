@extends('layouts.site.master')
@section('title', 'حساب کاربری من')
@section('content')
<section class="gr-account pt-40 pb-95">
    <div class="container">
        @if(session('swal'))
            <div class="alert alert-success">{{ session('swal')['message'] ?? 'انجام شد' }}</div>
        @endif

        <div class="row g-4">
            {{-- منوی راست --}}
            <div class="col-lg-3">
                <div class="gr-acc-sidebar">
                    <div class="gr-acc-user">
                        <div class="gr-acc-avatar">{{ mb_substr($user->first_name ?? $user->name, 0, 1) }}</div>
                        <div>
                            <div class="gr-acc-name">{{ $user->name }}</div>
                            <div class="gr-acc-mobile" dir="ltr">{{ $user->mobile }}</div>
                        </div>
                    </div>
                    <div class="nav flex-column gr-acc-nav" role="tablist" aria-orientation="vertical">
                        <button class="gr-acc-link active" data-bs-toggle="pill" data-bs-target="#tab-wallet" type="button">
                            <span class="gr-acc-ico">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M3 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H5a1 1 0 0 0 0 2h15a1 1 0 0 1 1 1v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z" stroke="currentColor" stroke-width="1.6"/><circle cx="16.5" cy="13.5" r="1.2" fill="currentColor"/></svg>
                            </span> کیف پول
                        </button>
                        <button class="gr-acc-link" data-bs-toggle="pill" data-bs-target="#tab-profile" type="button">
                            <span class="gr-acc-ico">
                                <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                            </span> پروفایل
                        </button>
                        <button class="gr-acc-link" data-bs-toggle="pill" data-bs-target="#tab-orders" type="button">
                            <span class="gr-acc-ico">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M6 2h9l4 4v16H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 11h7M9 15h7M9 7h3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                            </span> سفارش‌های من
                        </button>
                        <button class="gr-acc-link" data-bs-toggle="pill" data-bs-target="#tab-addresses" type="button">
                            <span class="gr-acc-ico">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M12 21s7-5.5 7-11a7 7 0 1 0-14 0c0 5.5 7 11 7 11Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span> آدرس‌ها
                        </button>
                        <button class="gr-acc-link" data-bs-toggle="pill" data-bs-target="#tab-custom" type="button">
                            <span class="gr-acc-ico">
                                <svg viewBox="0 0 24 24" fill="none"><path d="m12 3 2.7 5.5 6 .9-4.3 4.2 1 6L12 17l-5.4 2.6 1-6L3.3 9.4l6-.9L12 3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                            </span> سفارش‌های ویژه
                        </button>
                        <a class="gr-acc-link gr-acc-logout" href="{{ route('auth.logout') }}">
                            <span class="gr-acc-ico">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M15 4h3a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M10 8 6 12l4 4M6 12h11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span> خروج
                        </a>
                    </div>
                </div>
            </div>

            {{-- محتوای چپ --}}
            <div class="col-lg-9">
                <div class="tab-content gr-acc-content">
                    {{-- پروفایل --}}
                    <div class="tab-pane fade" id="tab-profile">
                        <h4 class="gr-acc-title">اطلاعات حساب</h4>
                        <table class="gr-acc-table">
                            <tbody>
                                <tr><th>نام</th><td>{{ $user->first_name ?? $user->name }}</td></tr>
                                <tr><th>نام خانوادگی</th><td>{{ $user->last_name ?? '—' }}</td></tr>
                                <tr><th>موبایل</th><td dir="ltr">{{ $user->mobile }}</td></tr>
                                <tr><th>تاریخ تولد</th><td>{{ $user->birthday ? gdate($user->birthday) : '—' }}</td></tr>
                            </tbody>
                        </table>
                        <p class="gr-acc-hint">برای تکمیل اطلاعات ارسال (کد ملی، کد پستی، آدرس) از بخش «آدرس‌ها» یک آدرس جدید ثبت کنید.</p>
                    </div>

                    {{-- سفارش‌ها --}}
                    <div class="tab-pane fade" id="tab-orders">
                        <h4 class="gr-acc-title">سفارش‌های من</h4>
                        <table class="gr-acc-table">
                            <thead><tr><th>شماره</th><th>مبلغ</th><th>تاریخ</th><th>فاکتور</th></tr></thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ number_format($order->total) }} تومان</td>
                                        <td>{{ gdate($order->created_at) }}</td>
                                        <td><a href="{{ route('account.orders.show', $order) }}" style="color:#343265;font-weight:700;">مشاهده</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">هنوز سفارشی ثبت نکرده‌اید.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- آدرس‌ها --}}
                    <div class="tab-pane fade" id="tab-addresses">
                        <h4 class="gr-acc-title">آدرس‌های من</h4>
                        <table class="gr-acc-table mb-4">
                            <thead><tr><th>گیرنده</th><th>موبایل</th><th>کد پستی</th><th>استان/شهر</th><th>آدرس</th></tr></thead>
                            <tbody>
                                @forelse($addresses as $a)
                                    <tr>
                                        <td>{{ $a->receiver }}</td>
                                        <td dir="ltr">{{ $a->mobile }}</td>
                                        <td dir="ltr">{{ $a->postal_code }}</td>
                                        <td>{{ optional(optional($a->city)->province)->name }} / {{ optional($a->city)->name }}</td>
                                        <td style="max-width:240px;">{{ $a->body }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted py-4">هنوز آدرسی ثبت نکرده‌اید.</td></tr>
                                @endforelse
                            </tbody>
                        </table>

                        <h5 class="gr-acc-subtitle">افزودن آدرس جدید</h5>
                        <form method="POST" action="{{ route('address.store') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4"><input name="receiver" class="form-control" placeholder="نام گیرنده" value="{{ old('receiver') }}" required></div>
                                <div class="col-md-4"><input name="mobile" class="form-control" placeholder="موبایل" value="{{ old('mobile', $user->mobile) }}" required></div>
                                <div class="col-md-4"><input name="national_code" class="form-control" placeholder="کد ملی (۱۰ رقم)" value="{{ old('national_code') }}" required></div>
                                <div class="col-md-4"><input name="postal_code" class="form-control" placeholder="کد پستی" value="{{ old('postal_code') }}" required></div>
                                <div class="col-md-4">
                                    <select name="city_id" class="form-control" required>
                                        <option value="">انتخاب شهر</option>
                                        @foreach($provinces as $province)
                                            <optgroup label="{{ $province->name }}">
                                                @foreach($province->cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4"><input type="date" name="birthday" class="form-control" value="{{ old('birthday', $user->birthday) }}"></div>
                                <div class="col-12"><textarea name="body" class="form-control" rows="2" placeholder="آدرس کامل" required>{{ old('body') }}</textarea></div>
                            </div>
                            <button type="submit" class="gr-acc-btn mt-3">ذخیره آدرس</button>
                        </form>
                    </div>

                    {{-- کیف پول --}}
                    <div class="tab-pane fade show active" id="tab-wallet">
                        <h4 class="gr-acc-title">کیف پول</h4>
                        <div class="gr-wallet-card">
                            <div class="gr-wallet-card-label">موجودی قابل استفاده</div>
                            <div class="gr-wallet-card-amount">{{ number_format($wallet->usableBalance()) }} <span>تومان</span></div>
                            @if(! $wallet->isExpired() && $wallet->expires_at)
                                <div class="gr-wallet-card-exp">اعتبار تا {{ gdate($wallet->expires_at) }}</div>
                            @endif
                        </div>
                        <table class="gr-acc-table mt-4">
                            <tbody>
                                <tr><th>آخرین شارژ</th><td>{{ number_format($wallet->last_charge) }} تومان</td></tr>
                                <tr><th>وضعیت اعتبار</th><td>{{ $wallet->isExpired() ? 'منقضی شده' : 'معتبر تا ' . gdate($wallet->expires_at) }}</td></tr>
                                <tr><th>شارژ خرید بعدی</th><td>{{ number_format($wallet->nextReward()) }} تومان</td></tr>
                            </tbody>
                        </table>
                        <p class="gr-acc-hint">بعد از هر خرید موفق کیف پول شارژ می‌شود؛ بار اول ۲۰۰٬۰۰۰ تومان و هر بار ۵۰٬۰۰۰ تومان بیشتر. اعتبار ۳ ماهه است.</p>
                    </div>

                    {{-- سفارش‌های ویژه --}}
                    <div class="tab-pane fade" id="tab-custom">
                        <h4 class="gr-acc-title">سفارش‌های ویژه‌ی من</h4>
                        @forelse($customOrders as $co)
                            @php
                                $st = $co->status->value;
                                $b = [
                                    'pending'  => ['#fff7e6', '#8a5a00', 'در انتظار بررسی'],
                                    'approved' => ['#ecedf7', '#343265', 'تأیید شد - در انتظار پرداخت'],
                                    'rejected' => ['#fdeeee', '#9c2542', 'رد شد'],
                                    'paid'     => ['#e8f8ef', '#1f9d55', 'پرداخت شد - در حال تولید'],
                                ][$st] ?? ['#f3f3f3', '#555', $st];
                            @endphp
                            <div style="border:1px solid #eef0f3;border-radius:8px;padding:16px;margin-bottom:12px;">
                                <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap:8px;">
                                    <strong>{{ $co->product->name ?? 'محصول' }} <span style="color:#999;font-size:12px;">— #{{ $co->id }}</span></strong>
                                    <span style="background:{{ $b[0] }};color:{{ $b[1] }};padding:4px 12px;border-radius:8px;font-size:12px;font-weight:700;">{{ $b[2] }}</span>
                                </div>
                                <div style="color:#666;font-size:13px;line-height:2;margin-top:8px;">
                                    <div>تعداد: {{ $co->quantity }} — تاریخ: {{ gdate($co->created_at) }}</div>
                                    @if($co->unit_price)
                                        <div style="color:#111;font-weight:700;">مبلغ کل: {{ number_format($co->total) }} تومان</div>
                                    @endif
                                    @if($co->admin_note)<div style="background:#f6f8fb;border-radius:8px;padding:8px 10px;margin-top:4px;">{{ $co->admin_note }}</div>@endif
                                </div>
                                @if($co->isPayable())
                                    <a href="{{ route('custom.order.pay', $co) }}" class="gr-acc-btn" style="display:inline-block;margin-top:10px;text-decoration:none;">پرداخت {{ number_format($co->total) }} تومان</a>
                                @endif
                            </div>
                        @empty
                            <p class="text-center text-muted py-4">سفارش ویژه‌ای ندارید. در صفحه‌ی محصولات ناموجود می‌توانید ثبت کنید.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
