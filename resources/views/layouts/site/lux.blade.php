<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="enamad" content="56209783"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'گالری رهنما — زیورآلات')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Markazi+Text:wght@400;500;600;700&family=Vazirmatn:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('site/assets/css/rahnama-lux.css') }}?v={{ filemtime(public_path('site/assets/css/rahnama-lux.css')) }}">

    @yield('customStyle')
</head>
<body class="lux anim btns-always">

@php($luxCartCount = \App\Models\Cart::existing()?->count ?? 0)
<header class="hdr">
    <div class="hdr-inner">
        <nav class="hdr-nav">
            <a href="{{ url('/') }}">خانه</a>
            <a href="{{ route('products.index') }}">محصولات</a>
            <a href="{{ route('discounts.index') }}" class="hdr-nav-sale {{ request()->routeIs('discounts.*') ? 'active' : '' }}">تخفیفات</a>
        </nav>

        <div class="hdr-cart">
            @guest('web')
                <a href="{{ route('auth.login.form') }}" class="hdr-login-btn">ورود / ثبت‌نام</a>
            @endguest
            @auth('web')
                <a href="{{ route('account.profile') }}" class="hdr-login-btn">حساب کاربری</a>
                <a href="{{ route('auth.logout') }}" class="hdr-login-btn hdr-logout-btn">خروج</a>
                @php($luxWallet = auth('web')->user()->wallet)
                <div class="wallet-wrap" id="lux-wallet">
                    <button type="button" class="walletbtn" title="کیف پول من">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H5a1 1 0 0 0 0 2h15a1 1 0 0 1 1 1v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z" stroke="currentColor" stroke-width="1.5"/>
                            <circle cx="16.5" cy="13.5" r="1.2" fill="currentColor"/>
                        </svg>
                        <span class="wallet-amount">{{ fa_toman($luxWallet->usableBalance()) }}</span>
                    </button>
                    <div class="wallet-menu">
                        <div class="wm-balance">
                            <span>موجودی کیف پول</span>
                            <strong>{{ fa_toman($luxWallet->usableBalance()) }}</strong>
                        </div>
                        @if($luxWallet->expires_at && ! $luxWallet->isExpired())
                            <div class="wm-note">اعتبار تا {{ fa_num(gdate($luxWallet->expires_at)) }}</div>
                        @else
                            <div class="wm-note">با اولین خرید {{ fa_toman(\App\Models\Wallet::FIRST_CHARGE) }} شارژ می‌شود</div>
                        @endif
                        <div class="wm-note">هر خرید موفق، کیف پول شما را شارژ می‌کند (اعتبار ۳ ماهه).</div>
                    </div>
                </div>
            @endauth

            <a href="{{ route('cart.index') }}" class="cartbtn" aria-label="سبد خرید">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.5 9V7a5.5 5.5 0 0 1 11 0v2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M4.2 9h15.6l-.9 10.2a2 2 0 0 1-2 1.8H7.1a2 2 0 0 1-2-1.8L4.2 9Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                </svg>
                @if($luxCartCount > 0)
                    <span class="cart-badge">{{ fa_num($luxCartCount) }}</span>
                @endif
            </a>
        </div>
    </div>
</header>

<main class="page">
    @yield('content')
</main>

<footer class="ftr">
    <div class="ftr-inner">
        <div class="ftr-brand">
            <a href="{{ url('/') }}" class="logo">گالری رهنما</a>
            <p>گالری رهنما، عرضه‌کننده‌ی انواع زیورآلات و اکسسوری با کیفیت — ساخته‌شده با وسواس، برای لحظه‌های خاص شما.</p>
            <p class="ftr-dim">قم — آنلاین‌شاپ گالری رهنما</p>
            <div class="ftr-social">
                <a href="https://instagram.com/galleryrahnama" target="_blank" rel="noopener">اینستاگرام</a>
                <a href="https://t.me/galleryrahnama" target="_blank" rel="noopener">تلگرام</a>
                <a href="https://rubika.ir/galleryrahnama" target="_blank" rel="noopener">روبیکا</a>
                <a href="https://eitaa.com/galleryrahnama" target="_blank" rel="noopener">ایتا</a>
                <a href="https://ble.ir/galleryrahnama" target="_blank" rel="noopener">بله</a>
            </div>
        </div>

        <div class="ftr-col">
            <h4>دسترسی سریع</h4>
            <a href="{{ url('/') }}">صفحه اصلی</a>
            <a href="{{ route('products.index') }}">محصولات</a>
            <a href="{{ route('discounts.index') }}">تخفیفات ویژه</a>
            <a href="{{ route('cart.index') }}">سبد خرید</a>
            @auth('web')
                <a href="{{ route('account.profile') }}">حساب کاربری</a>
            @else
                <a href="{{ route('auth.login.form') }}">ورود / ثبت‌نام</a>
            @endauth
        </div>

        <div class="ftr-col">
            <h4>سفارش دارید؟</h4>
            <a href="tel:09306756076" class="ftr-phone">09306756076</a>
            <a href="mailto:info@galleryrahnama.ir">info@galleryrahnama.ir</a>
            <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=740827&Code=W6oYZSk6exrFMThY3CoMhSOIhiiToZfB" style="margin-top:8px;">
                <img referrerpolicy="origin" src="https://trustseal.enamad.ir/logo.aspx?id=740827&Code=W6oYZSk6exrFMThY3CoMhSOIhiiToZfB" alt="نماد اعتماد الکترونیکی" style="max-width:96px;border-radius:4px;background:#fff;padding:4px;">
            </a>
        </div>
    </div>
    <div class="ftr-base">
        <a href="https://zrahnama.ir/">طراحی و برنامه‌نویسی وب‌سایت توسط رهنما</a>
    </div>
</footer>

{{-- نوبار پایین موبایل (مشابه اپلیکیشن) --}}
<nav class="tabbar" id="lux-tabbar">
    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
        <span class="tb-ico">
            <svg viewBox="0 0 24 24" fill="none"><path d="M3 10.5 12 3l9 7.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 9.5V21h14V9.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.5 21v-6h5v6" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
        </span>
        خانه
    </a>
    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
        <span class="tb-ico">
            <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7.5" height="7.5" rx="1.5" stroke="currentColor" stroke-width="1.7"/><rect x="13.5" y="3" width="7.5" height="7.5" rx="1.5" stroke="currentColor" stroke-width="1.7"/><rect x="3" y="13.5" width="7.5" height="7.5" rx="1.5" stroke="currentColor" stroke-width="1.7"/><rect x="13.5" y="13.5" width="7.5" height="7.5" rx="1.5" stroke="currentColor" stroke-width="1.7"/></svg>
        </span>
        محصولات
    </a>
    <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.index') ? 'active' : '' }}">
        <span class="tb-ico">
            <svg viewBox="0 0 24 24" fill="none"><path d="M6.5 9V7a5.5 5.5 0 0 1 11 0v2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><path d="M4.2 9h15.6l-.9 10.2a2 2 0 0 1-2 1.8H7.1a2 2 0 0 1-2-1.8L4.2 9Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
            @if($luxCartCount > 0)
                <span class="tb-badge">{{ fa_num($luxCartCount) }}</span>
            @endif
        </span>
        سبد خرید
    </a>
    <a href="{{ auth('web')->check() ? route('account.profile') . '#pane-wallet' : route('auth.login.form') }}" id="tb-wallet">
        <span class="tb-ico">
            <svg viewBox="0 0 24 24" fill="none"><path d="M3 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H5a1 1 0 0 0 0 2h15a1 1 0 0 1 1 1v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z" stroke="currentColor" stroke-width="1.7"/><circle cx="16.5" cy="13.5" r="1.2" fill="currentColor"/></svg>
        </span>
        کیف پول
    </a>
    <a href="{{ auth('web')->check() ? route('account.profile') . '#pane-profile' : route('auth.login.form') }}" id="tb-profile"
       class="{{ request()->routeIs('auth.login.form') || request()->routeIs('auth.register.form') ? 'active' : '' }}">
        <span class="tb-ico">
            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.7"/><path d="M4 20a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
        </span>
        پروفایل
    </a>
</nav>

@if(session('success') || session('message'))
    <div class="toast" id="lux-toast">{{ session('success') ?: session('message') }}</div>
@elseif(isset($errors) && $errors->any() && ! request()->routeIs('products.show'))
    <div class="toast" id="lux-toast">{{ $errors->first() }}</div>
@endif

<script>
// نمایش کارت‌ها هنگام اسکرول
(function () {
    const cards = document.querySelectorAll('.card');
    if (!('IntersectionObserver' in window)) {
        cards.forEach(c => c.classList.add('in'));
        return;
    }
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('in');
                io.unobserve(e.target);
            }
        });
    }, { rootMargin: '60px' });
    cards.forEach((c, i) => {
        c.style.setProperty('--rd', (i % 4) * 0.06 + 's');
        io.observe(c);
    });
})();

// محو شدن خودکار توست
(function () {
    const t = document.getElementById('lux-toast');
    if (!t) return;
    setTimeout(() => {
        t.style.transition = 'opacity .4s';
        t.style.opacity = '0';
        setTimeout(() => t.remove(), 450);
    }, 3600);
})();

// فیلدهای عددی: ارقام فارسی/عربی تایپ‌شده به لاتین تبدیل شود تا اعتبارسنجی سرور خراب نشود
document.querySelectorAll('.input-just-number').forEach(function (inp) {
    inp.addEventListener('input', function () {
        const fa = '۰۱۲۳۴۵۶۷۸۹', ar = '٠١٢٣٤٥٦٧٨٩';
        this.value = this.value
            .replace(/[۰-۹]/g, d => fa.indexOf(d))
            .replace(/[٠-٩]/g, d => ar.indexOf(d))
            .replace(/[^0-9]/g, '');
    });
});

// نوبار پایین: حالت فعال «کیف پول / پروفایل» بر اساس هشِ صفحه‌ی حساب
(function () {
    const w = document.getElementById('tb-wallet'), p = document.getElementById('tb-profile');
    if (!w || !p) return;
    function sync() {
        if (!location.pathname.includes('/account/')) return;
        const isWallet = !location.hash || location.hash === '#pane-wallet';
        w.classList.toggle('active', isWallet);
        p.classList.toggle('active', !isWallet);
    }
    sync();
    window.addEventListener('hashchange', sync);
})();

// باز و بسته شدن منوی کیف پول با لمس (موبایل)
(function () {
    const w = document.getElementById('lux-wallet');
    if (!w) return;
    w.querySelector('.walletbtn').addEventListener('click', function (e) {
        e.stopPropagation();
        w.classList.toggle('open');
    });
    document.addEventListener('click', () => w.classList.remove('open'));
})();

// نوار دسته‌بندی: فلش‌ها و سایه‌ی لبه‌ها
(function () {
    const track = document.querySelector('.catbar-track');
    if (!track) return;
    const fr = document.querySelector('.catfade.f-right');
    const fl = document.querySelector('.catfade.f-left');
    const ar = document.querySelector('.catarrow.ar-right');
    const al = document.querySelector('.catarrow.ar-left');

    function refresh() {
        const max = track.scrollWidth - track.clientWidth;
        if (max < 4) {
            [fr, fl, ar, al].forEach(el => el && (el.style.display = 'none'));
            return;
        }
        // در RTL مقدار scrollLeft منفی است
        const x = Math.abs(track.scrollLeft);
        fr && fr.classList.toggle('show', x > 4);
        fl && fl.classList.toggle('show', x < max - 4);
        ar && (ar.style.visibility = x > 4 ? 'visible' : 'hidden');
        al && (al.style.visibility = x < max - 4 ? 'visible' : 'hidden');
    }
    ar && ar.addEventListener('click', () => track.scrollBy({ left: 220, behavior: 'smooth' }));
    al && al.addEventListener('click', () => track.scrollBy({ left: -220, behavior: 'smooth' }));
    track.addEventListener('scroll', refresh, { passive: true });
    window.addEventListener('resize', refresh);
    refresh();
})();
</script>

@yield('customScript')
</body>
</html>
