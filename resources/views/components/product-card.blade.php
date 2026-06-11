@props(['product'])
@php
    $inStock = (int) $product->inventory > 0;
@endphp
<div class="tp-product-item-2 gr-card mb-30">
    <div class="tp-product-thumb-2 p-relative z-index-1 fix">
        <span class="gr-stock-on-img {{ $inStock ? 'is-in' : 'is-out' }}">{{ $inStock ? 'موجود' : 'ناموجود' }}</span>
        <a href="{{ route('products.show', $product->slug) }}" class="gr-card-thumb">
            <img src="{{ $product->poster_url }}" alt="{{ $product->name }}">
        </a>
    </div>

    <div class="tp-product-content-2 pt-15 text-center">
        <h3 class="tp-product-title-2">
            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
        </h3>

        <div class="gr-card-price-row justify-content-center">
            <span class="tp-product-price-2 new-price">@if($product->hasPricedVariants())از @endif{{ number_format($product->starting_price) }} تومان</span>
        </div>

        {{-- دو دکمه‌ی متنی کنار هم: جزئیات | افزودن به سبد / سفارش بده --}}
        <div class="gr-card-btns">
            <a href="{{ route('products.show', $product->slug) }}" class="gr-btn gr-btn-outline">جزئیات</a>
            @if($inStock)
                <a href="{{ route('add.to.cart', $product) }}" class="gr-btn gr-btn-fill">افزودن به سبد خرید</a>
            @else
                <a href="{{ route('products.show', $product->slug) }}" class="gr-btn gr-btn-order">ثبت سفارش</a>
            @endif
        </div>
    </div>
</div>
