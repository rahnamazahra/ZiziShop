@extends('layouts.site.lux')

@section('title', 'سبد خرید — گالری رهنما')

@section('content')
    <div class="cart-page">

        {{-- مسیر --}}
        <nav class="crumb">
            <a href="{{ url('/') }}">خانه</a>
            <span>/</span>
            <b>سبد خرید</b>
        </nav>

        @if($cart->products->isEmpty())
            <div class="cart-empty">
                <div class="ornament"><i></i><b>✦</b><i></i></div>
                <h2 class="goldtext">سبد خرید شما خالی است</h2>
                <p>هنوز محصولی به سبد اضافه نکرده‌اید.</p>
                <a href="{{ url('/') }}" class="buybtn">مشاهده محصولات</a>
            </div>
        @else
            <div class="cart-grid">

                {{-- اقلام سبد --}}
                <div>
                    <div class="cart-lines">
                        @foreach($cart->products as $product)
                            <div class="cart-line">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <img class="cart-line-img" src="{{ $product->poster_url }}" alt="{{ $product->name }}">
                                </a>
                                <div class="cart-line-name">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                </div>

                                <div class="cart-line-tools">
                                    <span class="cart-line-price">{{ fa_toman($cart->lineUnitPrice($product)) }}</span>

                                    <div class="qty">
                                        <button type="button" class="js-line-inc" data-url="{{ route('cart.increase', $product) }}" aria-label="افزایش">+</button>
                                        <span>{{ fa_num($product->pivot->count) }}</span>
                                        <button type="button" class="js-line-dec" data-url="{{ route('cart.decrease', $product) }}" aria-label="کاهش">−</button>
                                    </div>

                                    <form action="{{ route('remove.to.cart', ['product' => $product]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cart-remove">✕ حذف</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- کد کوپن --}}
                    <form action="{{ route('vouch') }}" method="post" class="cart-coupon">
                        @csrf
                        <input type="text" name="voucher" class="f-input" placeholder="کد کوپن را وارد کنید">
                        <button type="submit" class="buybtn">اعمال</button>
                    </form>
                </div>

                {{-- خلاصه سفارش --}}
                <aside class="cart-sum">
                    <h3 class="goldtext">خلاصه سفارش</h3>

                    <div class="sum-row">
                        <span>مجموع فرعی</span>
                        <b>{{ fa_toman($cart->raw_total) }}</b>
                    </div>

                    @if($cart->voucher)
                        <div class="sum-voucher">
                            کوپن «{{ $cart->voucher->code }}»
                            @if($cart->voucher->amount)
                                — {{ fa_toman($cart->voucher->amount) }} تخفیف
                            @else
                                — {{ fa_num($cart->voucher->discount_percent) }}٪ تخفیف
                            @endif
                        </div>
                    @endif

                    <div class="ship-opts">
                        <span class="opt-label">ارسال</span>
                        <label class="ship-opt"><input id="flat_rate" type="radio" name="shipping"> نرخ ثابت: <em>{{ fa_num(20) }} تومان</em></label>
                        <label class="ship-opt"><input id="local_pickup" type="radio" name="shipping"> تحویل محلی: <em>{{ fa_num(25) }} تومان</em></label>
                        <label class="ship-opt"><input id="free_shipping" type="radio" name="shipping"> ارسال رایگان</label>
                    </div>

                    <div class="sum-row total">
                        <span>مجموع</span>
                        <b>{{ fa_toman($cart->total) }}</b>
                    </div>

                    {{-- اطلاعات ارسال --}}
                    <div class="addr-box">
                        <span class="opt-label">اطلاعات ارسال</span>

                        @auth('web')
                            @if($cart->address)
                                <div class="addr-current">آدرس انتخاب‌شده: {{ $cart->address->receiver }} — {{ optional($cart->address->city)->name }}</div>
                            @endif

                            @if($addresses->count())
                                <form method="post" id="grSelectAddrForm" data-base="{{ url('address') }}" style="margin-bottom:12px;">
                                    @csrf
                                    <select class="f-select" id="grAddrSelect" style="margin-bottom:10px;">
                                        <option value="">انتخاب آدرس قبلی...</option>
                                        @foreach($addresses as $a)
                                            <option value="{{ $a->id }}" {{ $cart->address_id == $a->id ? 'selected' : '' }}>
                                                {{ $a->receiver }} — {{ \Illuminate\Support\Str::limit($a->body, 30) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="buybtn" style="width:100%;padding:10px;font-size:13px;">انتخاب این آدرس</button>
                                </form>
                            @endif

                            <details class="addr-new" {{ $addresses->count() ? '' : 'open' }}>
                                <summary>افزودن آدرس جدید</summary>
                                <form method="post" action="{{ route('address.store') }}">
                                    @csrf
                                    <label class="f-label" for="addr-receiver">نام گیرنده</label>
                                    <input id="addr-receiver" name="receiver" class="f-input" value="{{ auth('web')->user()->name }}" required>

                                    <label class="f-label" for="addr-mobile">موبایل</label>
                                    <input id="addr-mobile" name="mobile" class="f-input input-just-number" inputmode="numeric" maxlength="11" value="{{ auth('web')->user()->mobile }}" required dir="ltr" style="text-align:right;">

                                    <label class="f-label" for="addr-national">کد ملی (۱۰ رقم)</label>
                                    <input id="addr-national" name="national_code" class="f-input input-just-number" inputmode="numeric" maxlength="10" required dir="ltr" style="text-align:right;">

                                    <label class="f-label" for="addr-postal">کد پستی</label>
                                    <input id="addr-postal" name="postal_code" class="f-input input-just-number" inputmode="numeric" maxlength="10" required dir="ltr" style="text-align:right;">

                                    <label class="f-label" for="addr-city">شهر</label>
                                    <select id="addr-city" name="city_id" class="f-select" required>
                                        <option value="">انتخاب شهر</option>
                                        @foreach($provinces as $p)
                                            <optgroup label="{{ $p->name }}">
                                                @foreach($p->cities as $c)
                                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>

                                    @if(is_null(auth('web')->user()->birthday))
                                        <label class="f-label" for="addr-birthday">تاریخ تولد</label>
                                        <input type="date" id="addr-birthday" name="birthday" class="f-input" max="{{ now()->subDay()->toDateString() }}">
                                        <div class="addr-note">
                                            🎁 با ثبت تاریخ تولد، در روز تولدتان از هدایا و سورپرایزهای ویژه‌ی گالری رهنما بهره‌مند می‌شوید.
                                        </div>
                                    @else
                                        <div class="addr-note">
                                            🎂 تاریخ تولد شما ثبت شده است؛ روز تولدتان منتظر سورپرایز گالری رهنما باشید. (برای ویرایش با پشتیبانی تماس بگیرید)
                                        </div>
                                    @endif

                                    <label class="f-label" for="addr-body">آدرس کامل</label>
                                    <textarea id="addr-body" name="body" class="f-textarea" rows="2" required></textarea>

                                    <div style="margin-top:14px;">
                                        <button type="submit" class="buybtn" style="width:100%;padding:10px;font-size:13px;">ذخیره و انتخاب</button>
                                    </div>
                                </form>
                            </details>
                        @else
                            <p style="font-size:13px;color:var(--ink-2);">
                                برای تکمیل خرید ابتدا <a href="{{ route('auth.login.form') }}" style="color:var(--gold);">وارد شوید</a>.
                            </p>
                        @endauth
                    </div>

                    {{-- پرداخت --}}
                    <form method="post" action="{{ route('checkout') }}" style="margin-top:18px;">
                        @csrf
                        <button type="submit" class="buybtn" style="width:100%;">رفتن به پرداخت</button>
                    </form>
                </aside>
            </div>
        @endif
    </div>
@endsection

@section('customScript')
<script>
// انتخاب آدرس: آدرسِ مقصد فرم هنگام ارسال ساخته می‌شود (نه فقط هنگام تغییر سلکت)
(function () {
    const form = document.getElementById('grSelectAddrForm');
    if (!form) return;
    form.addEventListener('submit', function (e) {
        const sel = document.getElementById('grAddrSelect');
        if (!sel.value) {
            e.preventDefault();
            sel.focus();
            return;
        }
        form.action = form.dataset.base + '/' + sel.value + '/select';
    });
})();

// افزایش/کاهش تعداد اقلام سبد (با حفظ منطق سرور) و بارگذاری مجدد صفحه
document.querySelectorAll('.js-line-inc, .js-line-dec').forEach(function (btn) {
    btn.addEventListener('click', function () {
        btn.disabled = true;
        fetch(btn.dataset.url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
            },
        }).then(() => window.location.reload())
          .catch(() => { btn.disabled = false; });
    });
});
</script>
@endsection
