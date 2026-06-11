<div class="cartmini__area cartmini__style-darkRed">
    <div class="cartmini__wrapper d-flex justify-content-between flex-column">
        <div class="cartmini__top-wrapper">
            <div class="cartmini__top p-relative">
                <div class="cartmini__top-title">
                    <h4>سبد خرید</h4>
                </div>
                <div class="cartmini__close">
                    <button type="button" class="cartmini__close-btn cartmini-close-btn">✕</button>
                </div>
            </div>

            <div class="js-cartmini-body">
                @include('layouts.site.cartmini-content', ['cart' => $cart ?? null])
            </div>
        </div>
        <div class="cartmini__checkout">
            <div class="cartmini__checkout-btn">
                <a href="{{ route('cart.index') }}" class="tp-btn mb-10 w-100">مشاهده سبد خرید</a>
                <a href="{{ route('cart.index') }}" class="tp-btn tp-btn-border w-100">تسویه حساب</a>
            </div>
        </div>
    </div>
</div>
