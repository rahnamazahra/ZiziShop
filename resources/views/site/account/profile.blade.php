@extends('layouts.site.lux')

@section('title', 'حساب کاربری من — گالری رهنما')

@section('content')
<div class="acc-page">

    <nav class="crumb">
        <a href="{{ url('/') }}">خانه</a>
        <span>/</span>
        <b>حساب کاربری</b>
    </nav>

    <div class="acc-grid">
        {{-- منوی کنار --}}
        <aside class="acc-side">
            <div class="acc-user">
                <div class="acc-avatar">{{ mb_substr($user->first_name ?? $user->name, 0, 1) }}</div>
                <div>
                    <div class="acc-username">{{ $user->name }}</div>
                    <div class="acc-usermobile">{{ fa_num($user->mobile) }}</div>
                </div>
            </div>
            <div class="acc-nav">
                <button type="button" class="acc-link active" data-pane="pane-wallet">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M3 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H5a1 1 0 0 0 0 2h15a1 1 0 0 1 1 1v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z" stroke="currentColor" stroke-width="1.6"/><circle cx="16.5" cy="13.5" r="1.2" fill="currentColor"/></svg>
                    کیف پول
                </button>
                <button type="button" class="acc-link" data-pane="pane-profile">
                    <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                    پروفایل
                </button>
                <button type="button" class="acc-link" data-pane="pane-orders">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M6 2h9l4 4v16H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 11h7M9 15h7M9 7h3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                    سفارش‌های من
                </button>
                <button type="button" class="acc-link" data-pane="pane-addresses">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M12 21s7-5.5 7-11a7 7 0 1 0-14 0c0 5.5 7 11 7 11Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="1.6"/></svg>
                    آدرس‌ها
                </button>
                <button type="button" class="acc-link" data-pane="pane-custom">
                    <svg viewBox="0 0 24 24" fill="none"><path d="m12 3 2.7 5.5 6 .9-4.3 4.2 1 6L12 17l-5.4 2.6 1-6L3.3 9.4l6-.9L12 3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                    سفارش‌های ویژه
                </button>
                <a class="acc-link" href="{{ route('favorites.index') }}">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M12 21s-7.5-4.7-9.5-9.2C1 8 3 4.5 6.5 4.5c2 0 3.5 1 4.5 2.5C12 5.5 13.5 4.5 15.5 4.5 19 4.5 21 8 20.5 11.8 19.5 16.3 12 21 12 21Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                    علاقه‌مندی‌ها
                </a>
                <a class="acc-link logout" href="{{ route('auth.logout') }}">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M15 4h3a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M10 8 6 12l4 4M6 12h11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    خروج
                </a>
            </div>
        </aside>

        {{-- محتوا --}}
        <div>
            {{-- کیف پول --}}
            <section class="acc-pane active" id="pane-wallet">
                <h2 class="acc-title goldtext">کیف پول</h2>
                <div class="wallet-card">
                    <div class="wc-label">موجودی قابل استفاده</div>
                    <div class="wc-amount">{{ fa_num(number_format($wallet->usableBalance())) }} <span>تومان</span></div>
                    @if(! $wallet->isExpired() && $wallet->expires_at)
                        <div class="wc-exp">اعتبار تا {{ fa_num(gdate($wallet->expires_at)) }}</div>
                    @endif
                </div>
                <table class="spec-table" style="max-width:460px;margin-top:18px;">
                    <tbody>
                        <tr><th>آخرین شارژ</th><td>{{ fa_toman($wallet->last_charge) }}</td></tr>
                        <tr><th>وضعیت اعتبار</th><td>{{ $wallet->isExpired() ? 'منقضی شده' : 'معتبر تا ' . fa_num(gdate($wallet->expires_at)) }}</td></tr>
                        <tr><th>شارژ خرید بعدی</th><td>{{ fa_toman($wallet->nextReward()) }}</td></tr>
                    </tbody>
                </table>
                <p class="acc-hint">بعد از هر خرید موفق کیف پول شارژ می‌شود؛ بار اول {{ fa_toman(\App\Models\Wallet::FIRST_CHARGE) }} و هر بار {{ fa_toman(\App\Models\Wallet::STEP) }} بیشتر. اعتبار ۳ ماهه است.</p>
            </section>

            {{-- پروفایل --}}
            <section class="acc-pane" id="pane-profile">
                <h2 class="acc-title goldtext">اطلاعات حساب</h2>
                <table class="spec-table" style="max-width:520px;">
                    <tbody>
                        <tr><th>نام</th><td>{{ $user->first_name ?? $user->name }}</td></tr>
                        <tr><th>نام خانوادگی</th><td>{{ $user->last_name ?? '—' }}</td></tr>
                        <tr><th>موبایل</th><td style="direction:ltr;text-align:right;">{{ fa_num($user->mobile) }}</td></tr>
                        <tr><th>تاریخ تولد</th><td>{{ $user->birthday ? fa_num(gdate($user->birthday)) : '—' }}</td></tr>
                    </tbody>
                </table>
                <p class="acc-hint">برای تکمیل اطلاعات ارسال (کد ملی، کد پستی، آدرس) از بخش «آدرس‌ها» یک آدرس جدید ثبت کنید.</p>
            </section>

            {{-- سفارش‌ها --}}
            <section class="acc-pane" id="pane-orders">
                <h2 class="acc-title goldtext">سفارش‌های من</h2>
                @forelse($orders as $order)
                    <div class="acc-card">
                        <div class="acc-card-head">
                            <strong>سفارش <span class="muted">#{{ fa_num($order->id) }}</span></strong>
                            <span class="price" style="color:var(--gold);font-size:14px;">{{ fa_toman($order->total) }}</span>
                        </div>
                        <div class="acc-card-body">
                            <div>تاریخ ثبت: {{ fa_num(gdate($order->created_at)) }}</div>
                            @if($order->postal_tracking)
                                <div>📦 کد رهگیری پستی: <strong style="direction:ltr;display:inline-block;">{{ $order->postal_tracking }}</strong></div>
                            @endif
                        </div>
                        <a href="{{ route('account.orders.show', $order) }}" class="buybtn">مشاهده فاکتور</a>
                    </div>
                @empty
                    <p class="acc-empty">هنوز سفارشی ثبت نکرده‌اید.</p>
                @endforelse
            </section>

            {{-- آدرس‌ها --}}
            <section class="acc-pane" id="pane-addresses">
                <h2 class="acc-title goldtext">آدرس‌های من</h2>
                @forelse($addresses as $a)
                    <div class="acc-card">
                        <div class="acc-card-head">
                            <strong>{{ $a->receiver }}</strong>
                            <span class="muted" style="direction:ltr;">{{ fa_num($a->mobile) }}</span>
                        </div>
                        <div class="acc-card-body">
                            <div>{{ optional(optional($a->city)->province)->name }} / {{ optional($a->city)->name }} — کد پستی: {{ fa_num($a->postal_code) }}</div>
                            <div>{{ $a->body }}</div>
                        </div>
                    </div>
                @empty
                    <p class="acc-empty">هنوز آدرسی ثبت نکرده‌اید.</p>
                @endforelse

                <h3 class="acc-title" style="font-size:24px;margin-top:26px;">افزودن آدرس جدید</h3>
                <form method="POST" action="{{ route('address.store') }}" style="max-width:640px;">
                    @csrf
                    <div class="auth-row">
                        <div>
                            <label class="f-label" for="p-receiver">نام گیرنده</label>
                            <input id="p-receiver" name="receiver" class="f-input" value="{{ old('receiver', $user->name) }}" required>
                        </div>
                        <div>
                            <label class="f-label" for="p-mobile">موبایل</label>
                            <input id="p-mobile" name="mobile" class="f-input input-just-number" inputmode="numeric" maxlength="11" value="{{ old('mobile', $user->mobile) }}" required dir="ltr" style="text-align:right;">
                        </div>
                        <div>
                            <label class="f-label" for="p-national">کد ملی (۱۰ رقم)</label>
                            <input id="p-national" name="national_code" class="f-input input-just-number" inputmode="numeric" maxlength="10" value="{{ old('national_code') }}" required dir="ltr" style="text-align:right;">
                        </div>
                        <div>
                            <label class="f-label" for="p-postal">کد پستی</label>
                            <input id="p-postal" name="postal_code" class="f-input input-just-number" inputmode="numeric" maxlength="10" value="{{ old('postal_code') }}" required dir="ltr" style="text-align:right;">
                        </div>
                        <div>
                            <label class="f-label" for="p-city">شهر</label>
                            <select id="p-city" name="city_id" class="f-select" required>
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
                        @if(is_null($user->birthday))
                        <div>
                            <label class="f-label" for="p-birthday">تاریخ تولد</label>
                            <input type="date" id="p-birthday" name="birthday" class="f-input" value="{{ old('birthday') }}" max="{{ now()->subDay()->toDateString() }}">
                        </div>
                        @endif
                    </div>
                    @if(is_null($user->birthday))
                        <div class="addr-note">
                            🎁 با ثبت تاریخ تولد، در روز تولدتان از هدایا و سورپرایزهای ویژه‌ی گالری رهنما بهره‌مند می‌شوید.
                        </div>
                    @endif
                    <label class="f-label" for="p-body">آدرس کامل</label>
                    <textarea id="p-body" name="body" class="f-textarea" rows="2" required>{{ old('body') }}</textarea>
                    <div style="margin-top:16px;">
                        <button type="submit" class="buybtn" style="padding:11px 36px;">ذخیره آدرس</button>
                    </div>
                </form>
            </section>

            {{-- سفارش‌های ویژه --}}
            <section class="acc-pane" id="pane-custom">
                <h2 class="acc-title goldtext">سفارش‌های ویژه‌ی من</h2>
                @forelse($customOrders as $co)
                    @php
                        $st = $co->status->value;
                        $label = [
                            'pending'  => 'در انتظار بررسی',
                            'approved' => 'تأیید شد — در انتظار پرداخت',
                            'rejected' => 'رد شد',
                            'paid'     => 'پرداخت شد — در حال تولید',
                        ][$st] ?? $st;
                    @endphp
                    <div class="acc-card">
                        <div class="acc-card-head">
                            <strong>{{ $co->product->name ?? 'محصول' }} <span class="muted">#{{ fa_num($co->id) }}</span></strong>
                            <span class="st-chip st-{{ $st }}">{{ $label }}</span>
                        </div>
                        <div class="acc-card-body">
                            <div>تعداد: {{ fa_num($co->quantity) }} — تاریخ: {{ fa_num(gdate($co->created_at)) }}</div>
                            @if($co->unit_price)
                                <div class="price">مبلغ کل: {{ fa_toman($co->total) }}</div>
                            @endif
                            @if($co->admin_note)
                                <div class="acc-card-note">{{ $co->admin_note }}</div>
                            @endif
                        </div>
                        @if($co->isPayable())
                            <a href="{{ route('custom.order.pay', $co) }}" class="buybtn">پرداخت {{ fa_toman($co->total) }}</a>
                        @endif
                    </div>
                @empty
                    <p class="acc-empty">سفارش ویژه‌ای ندارید. در صفحه‌ی محصولات ناموجود می‌توانید ثبت کنید.</p>
                @endforelse
            </section>
        </div>
    </div>
</div>
@endsection

@section('customScript')
<script>
// تب‌های حساب کاربری (با پشتیبانی از #هش در آدرس)
(function () {
    const links = document.querySelectorAll('.acc-link[data-pane]');
    const panes = document.querySelectorAll('.acc-pane');

    function show(id) {
        panes.forEach(p => p.classList.toggle('active', p.id === id));
        links.forEach(l => l.classList.toggle('active', l.dataset.pane === id));
    }
    links.forEach(l => l.addEventListener('click', function () {
        show(this.dataset.pane);
        history.replaceState(null, '', '#' + this.dataset.pane);
    }));

    const hash = location.hash.replace('#', '');
    if (hash && document.getElementById(hash)) show(hash);
    // تغییر هش (مثلاً از نوبار پایین موبایل) → تعویض تب بدون رفرش
    window.addEventListener('hashchange', function () {
        const h = location.hash.replace('#', '');
        if (h && document.getElementById(h)) show(h);
    });
    // اگر خطای اعتبارسنجی فرم آدرس داشتیم، همان تب باز شود
    @if($errors->any()) show('pane-addresses'); @endif
})();
</script>
@endsection
