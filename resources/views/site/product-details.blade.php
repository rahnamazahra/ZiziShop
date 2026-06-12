@extends('layouts.site.lux')

@section('title', $product->name . ' — گالری رهنما')

@section('content')
    <div class="detail">

        {{-- مسیر --}}
        <nav class="crumb">
            <a href="{{ url('/') }}">خانه</a>
            <span>/</span>
            <a href="{{ url('/') }}">{{ $product->category->name }}</a>
            <span>/</span>
            <b>{{ $product->name }}</b>
        </nav>

        <div class="detail-grid">

            {{-- گالری تصاویر --}}
            @php $media = $product->images; @endphp
            <div>
                <div class="gallery-main" id="gr-gallery-main">
                    @if($media->isNotEmpty())
                        @php $first = $media->first(); @endphp
                        @if($first->isVideo())
                            <video src="{{ $first->url }}" controls playsinline preload="metadata"></video>
                        @else
                            <img class="gallery-img" src="{{ $first->url }}" alt="{{ $product->name }}">
                        @endif
                    @else
                        <img class="gallery-img" src="{{ $product->poster_url }}" alt="{{ $product->name }}">
                    @endif
                </div>

                @if($media->count() > 1)
                    <div class="gallery-thumbs">
                        @foreach($media as $i => $m)
                            <button type="button" class="gthumb {{ $i === 0 ? 'active' : '' }}"
                                    data-type="{{ $m->isVideo() ? 'video' : 'image' }}"
                                    data-src="{{ $m->url }}">
                                @if($m->isVideo())
                                    <video src="{{ $m->url }}" muted preload="metadata"></video>
                                    <span class="gthumb-play">▶</span>
                                @else
                                    <img class="thumb-img" src="{{ $m->url }}" alt="{{ $product->name }}">
                                @endif
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- اطلاعات محصول --}}
            <div class="dinfo">
                <div class="dinfo-cat">{{ $product->category->name }}</div>
                <h1 class="dinfo-name goldtext">{{ $product->name }}</h1>

                <div class="dinfo-meta">
                    @if($product->isInStock())
                        <span class="chip chip-stock">موجود</span>
                    @else
                        <span class="chip chip-oos">ناموجود</span>
                    @endif
                    @if($product->isOnSale())
                        <span class="chip chip-sale">{{ fa_num($product->discount) }}٪ تخفیف</span>
                    @endif
                    @if($product->sku)
                        <span class="dinfo-code">SKU: {{ $product->sku }}</span>
                    @endif
                </div>

                @php
                    $hasVariantPrices = $product->hasPricedVariants();
                    $productVoucher = $product->activeProductVoucher();
                @endphp
                <div class="dinfo-price">
                    @if($hasVariantPrices)
                        <span id="gr-pd-price">از {{ fa_toman($product->starting_price) }}</span>
                    @elseif($productVoucher)
                        @php $discounted = max(0, (int) $product->price - $productVoucher->discountFor($product)); @endphp
                        <span id="gr-pd-price">{{ fa_toman($discounted) }}</span>
                        <span class="old">{{ fa_toman($product->price) }}</span>
                        <span class="coupon">با کد «{{ $productVoucher->code }}»</span>
                    @elseif($product->isOnSale())
                        <span id="gr-pd-price">{{ fa_num($product->new_price) }}</span>
                        <span class="old">{{ fa_num($product->old_price) }}</span>
                    @else
                        <span id="gr-pd-price">{{ fa_num($product->old_price) }}</span>
                    @endif
                </div>

                @if($product->isOnSale() && $product->discount_until)
                    @php $daysLeft = $product->discountDaysLeft(); @endphp
                    <div class="discount-timer">
                        <span class="dt-cal">📅</span>
                        <span class="dt-label">تخفیف تا {{ fa_num(gdate($product->discount_until)) }}</span>
                        @if($daysLeft === 0)
                            <span class="dt-badge dt-today">آخرین روز!</span>
                        @elseif($daysLeft !== null && $daysLeft <= 3)
                            <span class="dt-badge dt-soon">{{ fa_num($daysLeft) }} روز مانده</span>
                        @elseif($daysLeft !== null)
                            <span class="dt-badge">{{ fa_num($daysLeft) }} روز مانده</span>
                        @endif
                    </div>
                @endif

                @if($product->description)
                    <p class="dinfo-desc">{{ $product->description }}</p>
                @endif

                <div class="ornament"><i></i><b>✦</b><i></i></div>

                @if($product->isInStock())
                    @php
                        $variantData = $product->stocks->map(fn($s) => [
                            'stock_id' => $s->id,
                            'color_id' => (int) $s->color_id,
                            'size_id'  => (int) $s->size_id,
                            'price'    => (int) ($s->price ?: $product->price),
                            'count'    => (int) $s->count,
                        ])->values();
                        $colorsU = $product->colors->unique('id');
                        $sizesU  = $product->sizes->unique('id');
                    @endphp

                    <div id="gr-variants" data-variants='@json($variantData)' data-base-price="{{ (int) $product->price }}">
                        @if($colorsU->isNotEmpty())
                            <div class="opt">
                                <span class="opt-label">رنگ</span>
                                <div class="opt-row">
                                    @foreach($colorsU as $color)
                                        <button type="button" class="swatch gr-color-btn" data-color-id="{{ $color->id }}">
                                            <i style="background: {{ $color->code ?: '#cccccc' }};"></i>
                                            {{ $color->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($sizesU->isNotEmpty())
                            <div class="opt">
                                <span class="opt-label">سایز</span>
                                <div class="opt-row">
                                    @foreach($sizesU as $size)
                                        <button type="button" class="sizepill gr-size-opt" data-size-id="{{ $size->id }}">{{ $size->name }}</button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="variant-status" id="gr-variant-status"></div>
                    </div>

                    <div class="buyrow">
                        <div class="qty">
                            <button type="button" class="js-qty-plus" aria-label="افزایش">+</button>
                            <span class="js-qty-val">۱</span>
                            <button type="button" class="js-qty-minus" aria-label="کاهش">−</button>
                        </div>
                        <a href="{{ route('add.to.cart', $product) }}"
                           class="buybtn js-add-to-cart"
                           data-base-url="{{ route('add.to.cart', $product) }}">افزودن به سبد خرید</a>
                    </div>

                    {{-- سفارش ویژه برای محصولات موجود: عمده‌فروشی / رنگ-سایز سفارشی --}}
                    <div class="special-order-wrap">
                        <button type="button" class="special-order-toggle" id="gr-sp-toggle">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                            سفارش ویژه (تعداد بالا / رنگ و سایز سفارشی)
                            <span class="sp-arrow" id="gr-sp-arrow">▾</span>
                        </button>
                        <div class="special-order-form preorder" id="gr-sp-form" style="display:none;">
                            <p class="preorder-hint">
                                اگر تعداد بیشتری از موجودی فعلی نیاز دارید، یا رنگ و سایز متفاوتی از همین محصول می‌خواهید،
                                می‌توانید اینجا سفارش ویژه ثبت کنید. پس از بررسی و اعلام قیمت، لینک پرداخت برای شما فعال می‌شود.
                            </p>

                            <form method="POST" action="{{ route('custom.order.store', $product) }}">
                                @csrf
                                @guest('web')
                                    <label for="sp_contact_name">نام و نام خانوادگی</label>
                                    <input type="text" name="contact_name" id="sp_contact_name" maxlength="100"
                                           value="{{ old('contact_name') }}" placeholder="نام شما" required>
                                    @error('contact_name') <div class="err">{{ $message }}</div> @enderror
                                @endguest

                                <div class="preorder-row">
                                    <div>
                                        <label for="sp_quantity">تعداد مورد نیاز</label>
                                        <input type="number" name="quantity" id="sp_quantity"
                                               min="1" max="10000" value="{{ old('quantity', 1) }}" required>
                                        @error('quantity') <div class="err">{{ $message }}</div> @enderror
                                    </div>
                                    <div>
                                        <label for="sp_contact_mobile">شماره تماس</label>
                                        <input type="text" name="contact_mobile" id="sp_contact_mobile" maxlength="11"
                                               value="{{ old('contact_mobile', auth('web')->user()->mobile ?? '') }}"
                                               placeholder="09xxxxxxxxx" required>
                                        @error('contact_mobile') <div class="err">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <label for="sp_description">توضیحات — رنگ، سایز، تعداد، هر درخواست دیگری</label>
                                <textarea name="description" id="sp_description" maxlength="1000"
                                          placeholder="مثال: ۵۰ عدد — رنگ مشکی — سایز XL — برای عمده‌فروشی" required>{{ old('description') }}</textarea>
                                @error('description') <div class="err">{{ $message }}</div> @enderror

                                <button type="submit" class="buybtn" style="width:100%;margin-top:16px;">ثبت سفارش ویژه</button>
                            </form>

                            @guest('web')
                                <p class="preorder-hint" style="margin:12px 0 0;">
                                    حساب کاربری دارید؟ <a href="{{ route('auth.login.form') }}">وارد شوید</a> تا سفارش‌هایتان را پیگیری کنید.
                                </p>
                            @endguest
                        </div>
                    </div>

                @else
                    {{-- محصول ناموجود: امکان ثبت سفارش ویژه (پیش‌سفارش) --}}
                    <div class="preorder">
                        <h4>این محصول فعلاً موجود نیست — می‌توانید سفارش بدهید</h4>
                        <p class="preorder-hint">
                            تعداد و توضیحات دلخواه (رنگ، سایز و …) را وارد کنید. پس از بررسی و تأیید کارشناسان ما و اعلام قیمت، می‌توانید پرداخت را انجام دهید تا این محصول دوباره برای شما تولید شود.
                        </p>

                        <form method="POST" action="{{ route('custom.order.store', $product) }}">
                            @csrf
                            @guest('web')
                                <label for="contact_name">نام و نام خانوادگی</label>
                                <input type="text" name="contact_name" id="contact_name" maxlength="100" value="{{ old('contact_name') }}" placeholder="نام شما" required>
                                @error('contact_name') <div class="err">{{ $message }}</div> @enderror
                            @endguest

                            <div class="preorder-row">
                                <div>
                                    <label for="quantity">تعداد</label>
                                    <input type="number" name="quantity" id="quantity" min="1" max="1000" value="{{ old('quantity', 1) }}" required>
                                    @error('quantity') <div class="err">{{ $message }}</div> @enderror
                                </div>
                                <div>
                                    <label for="contact_mobile">شماره تماس</label>
                                    <input type="text" name="contact_mobile" id="contact_mobile" maxlength="11" value="{{ old('contact_mobile', auth('web')->user()->mobile ?? '') }}" placeholder="09xxxxxxxxx" required>
                                    @error('contact_mobile') <div class="err">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <label for="description">توضیحات سفارش</label>
                            <textarea name="description" id="description" maxlength="1000" placeholder="رنگ، سایز، یا هر توضیح دیگری برای سفارش این محصول…" required>{{ old('description') }}</textarea>
                            @error('description') <div class="err">{{ $message }}</div> @enderror

                            <div style="margin-top:16px;">
                                <button type="submit" class="buybtn" style="width:100%;">ثبت سفارش ویژه</button>
                            </div>

                            @guest('web')
                                <p class="preorder-hint" style="margin:12px 0 0;">
                                    حساب کاربری دارید؟ <a href="{{ route('auth.login.form') }}">وارد شوید</a> تا سفارش‌هایتان را پیگیری کنید.
                                </p>
                            @endguest
                        </form>
                    </div>
                @endif

                <div class="notice">
                    <b>✦</b>
                    <span>
                        🎁 با خرید این محصول، کیف پول شما
                        <em>{{ fa_toman(auth('web')->check() ? auth('web')->user()->wallet->nextReward() : \App\Models\Wallet::FIRST_CHARGE) }}</em>
                        شارژ می‌شود — اعتبار ۳ ماهه و قابل استفاده در خرید بعدی. (هر خرید {{ fa_toman(\App\Models\Wallet::STEP) }} بیشتر از قبل!)
                    </span>
                </div>

                @if($product->weight || (is_array($product->features) && count($product->features)))
                    <table class="spec-table">
                        <tbody>
                            @if($product->weight)
                                <tr><th>وزن کلی</th><td>{{ fa_num($product->weight) }} گرم</td></tr>
                            @endif
                            @if(is_array($product->features))
                                @foreach($product->features as $feature)
                                    @if(!empty($feature['feature_key']))
                                        <tr><th>{{ $feature['feature_key'] }}</th><td>{{ $feature['feature_value'] ?? '' }}</td></tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                @endif

                <div class="notice notice-ship">
                    <b>✦</b>
                    <span>آماده‌سازی و ارسال مرسوله‌ی شما در بازه‌ی زمانی <em>۳ تا ۱۰ روز کاری</em> انجام می‌شود. برای ارسال سریع‌تر یا اطلاع دقیق از زمان ارسال، قبل از خرید با پشتیبانی تماس بگیرید.</span>
                </div>

                <p class="favline">
                    <a href="{{ route('add.to.favorites', ['product' => $product]) }}">♡ افزودن به علاقه‌مندی‌ها</a>
                </p>
            </div>
        </div>

        {{-- محصولات مرتبط --}}
        @php $related = ($relatedProducts ?? collect())->where('id', '!=', $product->id)->values(); @endphp
        @if($related->isNotEmpty())
            <section class="related">
                <div class="sec-title">
                    <div class="ornament"><i></i></div>
                    <span>محصولات مرتبط</span>
                    <div class="ornament"><i></i></div>
                </div>

                <div class="grid related-grid">
                    @foreach($related->take(8) as $i => $rp)
                        @php
                            $rpInStock = (int) $rp->inventory > 0;
                            $spans = ['sh3', 'sh4', 'sh3', 'sh4'];
                        @endphp
                        <article class="card {{ $spans[$i % 4] }} {{ $rpInStock ? '' : 'oos' }}"
                                 data-href="{{ route('products.show', $rp->slug) }}">
                            <div class="card-media">
                                <img class="card-img" src="{{ $rp->poster_url }}" alt="{{ $rp->name }}" loading="lazy">
                            </div>
                            <div class="sheen"></div>
                            <div class="card-veil"></div>
                            @unless($rpInStock)
                                <span class="chip chip-oos">ناموجود</span>
                            @endunless
                            <div class="card-info">
                                <div class="card-name">{{ $rp->name }}</div>
                                <div class="card-sub">{{ $rp->category->name ?? '' }}</div>
                                <div class="card-price">
                                    @if($rpInStock)
                                        @if($rp->hasPricedVariants()) از @endif{{ fa_toman($rp->starting_price) }}
                                    @else
                                        ناموجود
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('products.show', $rp->slug) }}" class="addbtn">مشاهده</a>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    {{-- نوار خرید چسبان موبایل --}}
    @if($product->isInStock())
        <div class="buybar">
            <span class="buybar-price js-buybar-price">
                @if($hasVariantPrices) از {{ fa_toman($product->starting_price) }}
                @else {{ fa_num($product->discount ? $product->new_price : $product->old_price) }}
                @endif
            </span>
            <div class="qty">
                <button type="button" class="js-qty-plus" aria-label="افزایش">+</button>
                <span class="js-qty-val">۱</span>
                <button type="button" class="js-qty-minus" aria-label="کاهش">−</button>
            </div>
            <a href="{{ route('add.to.cart', $product) }}"
               class="buybtn js-add-to-cart"
               data-base-url="{{ route('add.to.cart', $product) }}">افزودن به سبد</a>
        </div>
    @endif
@endsection

@section('customScript')
<script>
// تعویض عکس/فیلم اصلی با کلیک روی بندانگشتی‌ها
(function () {
    const main = document.getElementById('gr-gallery-main');
    const thumbs = document.querySelectorAll('.gthumb');
    if (!main || !thumbs.length) return;

    thumbs.forEach(function (t) {
        t.addEventListener('click', function () {
            thumbs.forEach(x => x.classList.remove('active'));
            t.classList.add('active');
            // فیلم در حال پخش متوقف شود
            const playing = main.querySelector('video');
            if (playing) playing.pause();

            if (t.dataset.type === 'video') {
                main.innerHTML = '<video src="' + t.dataset.src + '" controls playsinline preload="metadata"></video>';
            } else {
                main.innerHTML = '<img class="gallery-img" src="' + t.dataset.src + '" alt="">';
                bindZoom();
            }
        });
    });

    // زوم روی عکس اصلی
    function bindZoom() {
        const img = main.querySelector('img');
        if (!img) return;
        main.addEventListener('mousemove', move);
        main.addEventListener('mouseleave', leave);
        function move(e) {
            const cur = main.querySelector('img');
            if (!cur) return;
            const r = main.getBoundingClientRect();
            const x = ((e.clientX - r.left) / r.width) * 100;
            const y = ((e.clientY - r.top) / r.height) * 100;
            cur.style.transformOrigin = x + '% ' + y + '%';
            cur.style.transform = 'scale(2.2)';
        }
        function leave() {
            const cur = main.querySelector('img');
            if (cur) cur.style.transform = 'scale(1)';
        }
    }
    bindZoom();
})();

// انتخاب تنوع (رنگ/سایز) + بررسی موجودی + تعداد + ساخت لینک افزودن به سبد
(function () {
    const box = document.getElementById('gr-variants');
    const addBtns = document.querySelectorAll('.js-add-to-cart');
    if (!addBtns.length) return;

    const variants = box ? JSON.parse(box.dataset.variants || '[]') : [];
    const basePrice = box ? parseInt(box.dataset.basePrice || '0', 10) : 0;
    const priceEl = document.getElementById('gr-pd-price');
    const buybarPrice = document.querySelector('.js-buybar-price');
    const statusEl = document.getElementById('gr-variant-status');
    const qtyEls = document.querySelectorAll('.js-qty-val');
    const baseUrl = addBtns[0].dataset.baseUrl;
    const fmt = v => new Intl.NumberFormat('fa-IR').format(v);

    let selColor = null, selSize = null, qty = 1;
    const hasColors = box && box.querySelector('.gr-color-btn');
    const hasSizes  = box && box.querySelector('.gr-size-opt');

    function findStock() {
        return variants.find(v =>
            (!hasColors || v.color_id === selColor) &&
            (!hasSizes  || v.size_id === selSize)
        );
    }

    function setDisabled(d) {
        addBtns.forEach(b => {
            b.classList.toggle('is-disabled', d);
            b.href = d ? 'javascript:void(0)' : b.href;
        });
    }

    function setPrices(text) {
        if (priceEl) priceEl.textContent = text;
        if (buybarPrice) buybarPrice.textContent = text;
    }

    function refresh() {
        qtyEls.forEach(el => el.textContent = fmt(qty));

        if ((hasColors && !selColor) || (hasSizes && !selSize)) {
            if (statusEl) {
                statusEl.textContent = 'لطفاً رنگ و سایز را انتخاب کنید.';
                statusEl.className = 'variant-status is-hint';
            }
            setDisabled(true);
            return;
        }
        const stock = variants.length ? findStock() : null;
        if (variants.length && (!stock || stock.count < qty)) {
            if (statusEl) {
                statusEl.textContent = 'این ترکیب موجود نیست.';
                statusEl.className = 'variant-status is-out';
            }
            setDisabled(true);
            return;
        }
        if (statusEl) {
            statusEl.textContent = stock ? ('موجود (' + fmt(stock.count) + ' عدد)') : '';
            statusEl.className = 'variant-status is-in';
        }
        let url = baseUrl + '?qty=' + qty;
        if (stock) url += '&stock=' + stock.stock_id;
        addBtns.forEach(b => { b.classList.remove('is-disabled'); b.href = url; });
        if (stock) setPrices(fmt(stock.price) + ' تومان');
        else if (box) setPrices(fmt(basePrice) + ' تومان');
    }

    document.querySelectorAll('.gr-color-btn').forEach(b => b.addEventListener('click', function () {
        document.querySelectorAll('.gr-color-btn').forEach(x => x.classList.remove('active'));
        this.classList.add('active');
        selColor = parseInt(this.dataset.colorId, 10);
        refresh();
    }));
    document.querySelectorAll('.gr-size-opt').forEach(b => b.addEventListener('click', function () {
        document.querySelectorAll('.gr-size-opt').forEach(x => x.classList.remove('active'));
        this.classList.add('active');
        selSize = parseInt(this.dataset.sizeId, 10);
        refresh();
    }));

    document.querySelectorAll('.js-qty-plus').forEach(b => b.addEventListener('click', () => { qty++; refresh(); }));
    document.querySelectorAll('.js-qty-minus').forEach(b => b.addEventListener('click', () => { if (qty > 1) { qty--; refresh(); } }));

    addBtns.forEach(b => b.addEventListener('click', function (e) {
        if (this.classList.contains('is-disabled')) e.preventDefault();
    }));

    refresh();
})();

// کلیک روی کارت‌های مرتبط → صفحه‌ی محصول
document.querySelectorAll('.related .card').forEach(function (card) {
    card.addEventListener('click', function (e) {
        if (e.target.closest('.addbtn')) return;
        window.location.href = card.dataset.href;
    });
});

// باز/بسته شدن فرم سفارش ویژه (برای محصولات موجود)
(function () {
    const toggle = document.getElementById('gr-sp-toggle');
    const form   = document.getElementById('gr-sp-form');
    const arrow  = document.getElementById('gr-sp-arrow');
    if (!toggle || !form) return;
    toggle.addEventListener('click', function () {
        const open = form.style.display !== 'none';
        form.style.display = open ? 'none' : 'block';
        if (arrow) arrow.textContent = open ? '▾' : '▴';
        toggle.classList.toggle('active', !open);
    });
})();
</script>
@endsection
