@php($items = $cart?->products ?? collect())
<div class="cartmini__widget js-cartmini-widget">
    @forelse($items as $product)
        <div class="cartmini__widget-item" data-id="{{ $product->id }}">
            <div class="cartmini__thumb">
                <a href="{{ route('products.show', $product->slug) }}">
                    <img src="{{ $product->poster_url }}" alt="{{ $product->name }}">
                </a>
            </div>
            <div class="cartmini__content">
                <h5 class="cartmini__title">
                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                </h5>
                <div class="cartmini__price-wrapper">
                    <span class="cartmini__price">{{ number_format($cart->lineUnitPrice($product)) }} تومان</span>
                    <span class="cartmini__quantity">x{{ $product->pivot->count }}</span>
                </div>
                <div class="cartmini__quantity-control d-flex align-items-center mt-1" style="gap:8px;">
                    <button type="button" class="js-cart-decrease" data-id="{{ $product->id }}" style="width:24px;height:24px;border:1px solid #ddd;border-radius:4px;line-height:1;">-</button>
                    <span class="js-cart-count">{{ $product->pivot->count }}</span>
                    <button type="button" class="js-cart-increase" data-id="{{ $product->id }}" style="width:24px;height:24px;border:1px solid #ddd;border-radius:4px;line-height:1;">+</button>
                </div>
            </div>
            <button type="button" class="cartmini__del js-cart-remove" data-id="{{ $product->id }}" title="حذف">✕</button>
        </div>
    @empty
        <div class="cartmini__empty text-center">
            <p>سبد خرید شما خالی است</p>
            <a href="{{ route('products.index') }}" class="tp-btn">به فروشگاه بروید</a>
        </div>
    @endforelse
</div>
<div class="cartmini__checkout-subtotal d-flex align-items-center justify-content-between mt-20">
    <h4 class="m-0">جمع کل:</h4>
    <span class="js-cartmini-subtotal">{{ number_format($cart?->total ?? 0) }} تومان</span>
</div>
