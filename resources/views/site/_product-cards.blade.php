@php $spans = ['sh4','sh3','sh5','sh3','sh4','sh3','sh5','sh4']; @endphp
@foreach($products as $i => $product)
    @php
        $inStock = (int) $product->inventory > 0;
        $isNew   = $product->created_at && $product->created_at->gt(now()->subDays(14));
        $span    = $spans[($offset + $i) % count($spans)];
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
        @elseif($product->isOnSale())
            <span class="chip chip-sale">{{ fa_num($product->discount) }}٪ تخفیف</span>
        @elseif($isNew)
            <span class="chip chip-new">جدید</span>
        @endif

        <div class="card-info">
            <div class="card-name">{{ $product->name }}</div>
            <div class="card-sub">{{ $product->category->name ?? '' }}</div>
            <div class="card-price">
                @if($inStock)
                    @if($product->hasPricedVariants())
                        از {{ fa_toman($product->starting_price) }}
                    @elseif($product->isOnSale())
                        <span class="card-new-price">{{ fa_num($product->new_price) }}</span>
                        <del class="card-old-price">{{ fa_num($product->old_price) }}</del>
                    @else
                        {{ fa_toman($product->starting_price) }}
                    @endif
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
@endforeach
