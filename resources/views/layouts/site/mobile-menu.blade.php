<div id="tp-bottom-menu-sticky" class="gr-mobile-nav d-lg-none">
    <a href="{{ route('products.index') }}" class="gr-mobile-item">
        <svg viewBox="0 0 24 24" fill="none"><path d="M4 9h16l-1 11H5L4 9Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 9V6a3 3 0 0 1 6 0v3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
        <span>فروشگاه</span>
    </a>

    <button type="button" class="gr-mobile-item cartmini-open-btn">
        <span class="gr-mobile-badge js-cart-badge">{{ $total_count_cart ?? 0 }}</span>
        <svg viewBox="0 0 24 24" fill="none"><path d="M6 6h15l-1.5 9h-12L6 6Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M6 6 5 3H3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="9" cy="20" r="1.4" fill="currentColor"/><circle cx="18" cy="20" r="1.4" fill="currentColor"/></svg>
        <span>سبد خرید</span>
    </button>

    @auth('web')
    <a href="{{ route('account.profile') }}" class="gr-mobile-item gr-mobile-wallet">
        <svg viewBox="0 0 24 24" fill="none"><path d="M3 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H5a1 1 0 0 0 0 2h15a1 1 0 0 1 1 1v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z" stroke="currentColor" stroke-width="1.6"/><circle cx="16.5" cy="13.5" r="1.2" fill="currentColor"/></svg>
        <span>{{ number_format(auth('web')->user()->wallet->usableBalance()) }} ت</span>
    </a>
    @endauth

    <a href="{{ auth('web')->check() ? route('account.profile') : route('auth.login.form') }}" class="gr-mobile-item">
        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
        <span>پروفایل</span>
    </a>

    <button type="button" class="gr-mobile-item tp-offcanvas-open-btn">
        <svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
        <span>منو</span>
    </button>
</div>
