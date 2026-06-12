@extends('layouts.site.lux')

@section('title', 'علاقه‌مندی‌های من — گالری رهنما')

@section('content')
<div class="acc-page">
    <nav class="crumb">
        <a href="{{ url('/') }}">خانه</a>
        <span>/</span>
        <a href="{{ route('account.profile') }}">حساب کاربری</a>
        <span>/</span>
        <b>علاقه‌مندی‌ها</b>
    </nav>

    <h2 class="acc-title goldtext">علاقه‌مندی‌های من</h2>

    @if($products->isEmpty())
        <div class="cart-empty">
            <div class="ornament"><i></i><b>✦</b><i></i></div>
            <h2 class="goldtext">لیست علاقه‌مندی خالی است</h2>
            <p>محصولات موردعلاقه‌تان را با ♡ نشان کنید تا اینجا نمایش داده شوند.</p>
            <a href="{{ url('/') }}" class="buybtn">مشاهده محصولات</a>
        </div>
    @else
        <div class="cart-lines" style="max-width:860px;">
            @foreach($products as $product)
                @php $inStock = (int) $product->inventory > 0; @endphp
                <div class="cart-line">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <img class="cart-line-img" src="{{ $product->poster_url }}" alt="{{ $product->name }}">
                    </a>
                    <div class="cart-line-name">
                        <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                    </div>

                    <div class="cart-line-tools">
                        <span class="cart-line-price">
                            @if($inStock)
                                @if($product->hasPricedVariants()) از @endif{{ fa_toman($product->starting_price) }}
                            @else
                                ناموجود
                            @endif
                        </span>

                        @if($inStock)
                            <a href="{{ route('add.to.cart', $product) }}" class="buybtn" style="padding:9px 20px;font-size:12.5px;">افزودن به سبد</a>
                        @else
                            <a href="{{ route('products.show', $product->slug) }}" class="buybtn" style="padding:9px 20px;font-size:12.5px;">ثبت سفارش</a>
                        @endif

                        <a href="{{ route('remove.to.favorites', ['product' => $product]) }}" class="cart-remove">✕ حذف</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
