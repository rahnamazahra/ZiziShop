@extends('layouts.site.lux')

@section('content')

    {{-- هیرو --}}
    <section class="hero">
        <span class="spark s1">✦</span>
        <span class="spark s2">✦</span>
        <span class="spark s3">✦</span>

        <div class="ornament"><i></i><b>✦</b><i></i></div>
        <h1 class="hero-title goldtext">گالری رهنما</h1>
        <p class="hero-sub">زیورآلات و اکسسوری منتخب — برای لحظه‌های خاص شما</p>
    </section>

    {{-- نوار دسته‌بندی --}}
    <div class="catbar">
        <div class="catbar-wrap">
            <div class="catfade f-right"></div>
            <div class="catfade f-left"></div>
            <button type="button" class="catarrow ar-right" aria-label="قبلی">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <button type="button" class="catarrow ar-left" aria-label="بعدی">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>

            <div class="catbar-track">
                <button type="button" class="cat active" data-filter="all">
                    همه مجموعه ({{ fa_num($categories->sum('products_count')) }})
                </button>
                @foreach($categories as $category)
                    <button type="button" class="cat" data-filter="{{ $category->id }}">
                        {{ $category->name }} ({{ fa_num($category->products_count) }})
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- گرید محصولات --}}
    <section class="grid gallery" id="lux-grid">
        @forelse($products as $i => $product)
            @php
                $inStock = (int) $product->inventory > 0;
                $isNew = $product->created_at && $product->created_at->gt(now()->subDays(14));
                $spans = ['sh4', 'sh3', 'sh5', 'sh3', 'sh4', 'sh3', 'sh5', 'sh4'];
                $span = $spans[$i % count($spans)];
            @endphp
            <article class="card {{ $span }} {{ $inStock ? '' : 'oos' }}"
                     data-cat="{{ $product->category_id }}"
                     data-href="{{ route('products.show', $product->slug) }}">
                <div class="card-media">
                    <img class="card-img" src="{{ $product->poster_url }}" alt="{{ $product->name }}" loading="lazy">
                </div>
                <div class="sheen"></div>
                <div class="card-veil"></div>

                @if(! $inStock)
                    <span class="chip chip-oos">ناموجود</span>
                @elseif($isNew)
                    <span class="chip chip-new">جدید</span>
                @endif

                <div class="card-info">
                    <div class="card-name">{{ $product->name }}</div>
                    <div class="card-sub">{{ $product->category->name ?? '' }}</div>
                    <div class="card-price">
                        @if($inStock)
                            @if($product->hasPricedVariants()) از @endif{{ fa_toman($product->starting_price) }}
                        @else
                            ناموجود — قابل سفارش
                        @endif
                    </div>
                </div>

                @if($inStock)
                    <a href="{{ route('add.to.cart', $product) }}" class="addbtn">افزودن به سبد</a>
                @else
                    <a href="{{ route('products.show', $product->slug) }}" class="addbtn">ثبت سفارش</a>
                @endif
            </article>
        @empty
            <div class="grid-empty">هیچ آیتمی ثبت نشده است</div>
        @endforelse
    </section>

    <div id="lux-sentinel" class="lux-sentinel"@if(!$hasMore) style="display:none"@endif></div>
    <p class="scroll-hint"@if($hasMore) style="display:none"@endif>— پایان مجموعه —</p>

@endsection

@section('customScript')
<script>
(function () {
    const grid     = document.getElementById('lux-grid');
    const sentinel = document.getElementById('lux-sentinel');
    const hint     = document.querySelector('.scroll-hint');
    if (!grid) return;

    let cat      = 'all';
    let nextPage = 2;
    let hasMore  = {{ $hasMore ? 'true' : 'false' }};
    let loading  = false;
    let aborter  = null;

    function setupCard(card) {
        card.addEventListener('click', function (e) {
            if (e.target.closest('.addbtn')) return;
            window.location.href = card.dataset.href;
        });
    }

    function revealCards(cards) {
        if (!('IntersectionObserver' in window)) {
            cards.forEach(function (c) { c.classList.add('in'); });
            return;
        }
        const io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
            });
        }, { rootMargin: '60px' });
        cards.forEach(function (c, i) {
            c.style.setProperty('--rd', (i % 4) * 0.06 + 's');
            io.observe(c);
        });
    }

    function injectCards(html) {
        const tmp = document.createElement('div');
        tmp.innerHTML = html;
        const cards = Array.from(tmp.querySelectorAll('.card'));
        cards.forEach(function (c) { setupCard(c); grid.appendChild(c); });
        revealCards(cards);
    }

    async function doFetch(page, category) {
        if (aborter) aborter.abort();
        aborter = new AbortController();
        const qs  = new URLSearchParams({ page: page, category: category });
        const res = await fetch('{{ route('products.load-more') }}?' + qs, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            signal:  aborter.signal
        });
        return res.json();
    }

    async function loadMore() {
        if (loading || !hasMore) return;
        loading = true;
        if (sentinel) sentinel.classList.add('loading');
        try {
            const d = await doFetch(nextPage, cat);
            if (d.html) injectCards(d.html);
            hasMore  = d.hasMore;
            nextPage = d.nextPage;
            if (!hasMore) {
                if (sentinel) sentinel.style.display = 'none';
                if (hint)     hint.style.display     = '';
            }
        } catch (e) {
            if (e.name !== 'AbortError') console.error('infinite scroll:', e);
        } finally {
            loading = false;
            if (sentinel) sentinel.classList.remove('loading');
        }
    }

    async function switchCat(newCat) {
        if (aborter) aborter.abort();
        loading = false;

        Array.from(grid.querySelectorAll('.card, .grid-empty')).forEach(function (el) { el.remove(); });
        if (hint)     hint.style.display     = 'none';
        if (sentinel) { sentinel.style.display = ''; sentinel.classList.add('loading'); }

        cat      = newCat;
        nextPage = 1;
        hasMore  = true;
        loading  = true;

        try {
            const d = await doFetch(1, newCat);
            if (d.html && d.html.trim()) {
                injectCards(d.html);
            } else {
                const empty = document.createElement('div');
                empty.className   = 'grid-empty';
                empty.textContent = 'محصولی در این دسته وجود ندارد';
                grid.appendChild(empty);
            }
            hasMore  = d.hasMore;
            nextPage = d.nextPage;
            if (!hasMore) {
                if (sentinel) sentinel.style.display = 'none';
                if (hint)     hint.style.display     = '';
            }
        } catch (e) {
            if (e.name !== 'AbortError') console.error('category switch:', e);
        } finally {
            loading = false;
            if (sentinel) sentinel.classList.remove('loading');
        }
    }

    // اسکرول بی‌نهایت با IntersectionObserver روی sentinel
    if (sentinel && 'IntersectionObserver' in window) {
        new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) loadMore();
        }, { rootMargin: '400px' }).observe(sentinel);
    }

    // فیلتر دسته‌بندی — AJAX سمت سرور
    document.querySelectorAll('.catbar .cat').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.catbar .cat').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            switchCat(btn.dataset.filter);
        });
    });

    // کلیک روی کارت‌های اولیه (رندر سمت سرور)
    grid.querySelectorAll('.card').forEach(setupCard);
})();
</script>
@endsection
