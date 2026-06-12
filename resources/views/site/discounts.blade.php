@extends('layouts.site.lux')

@section('title', 'تخفیفات — گالری رهنما')

@section('content')
<div class="disc-page">
    <nav class="crumb">
        <a href="{{ url('/') }}">خانه</a>
        <span>/</span>
        <b>تخفیفات ویژه</b>
    </nav>

    <div class="sec-title" style="margin-bottom:28px;">
        <div class="ornament"><i></i></div>
        <span>تخفیفات ویژه</span>
        <div class="ornament"><i></i></div>
    </div>

    @if(count($products))
        <div class="grid" id="disc-grid">
            @include('site._product-cards', ['products' => $products, 'offset' => 0])
        </div>

        {{-- صفحه‌بندی --}}
        @if($paginator->hasPages())
            <div class="lux-pagination">
                @if($paginator->onFirstPage())
                    <span class="disabled">قبلی</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}">قبلی</a>
                @endif
                <span>صفحه {{ fa_num($paginator->currentPage()) }} از {{ fa_num($paginator->lastPage()) }}</span>
                @if($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}">بعدی</a>
                @else
                    <span class="disabled">بعدی</span>
                @endif
            </div>
        @endif
    @else
        <p style="text-align:center;color:var(--ink-2);padding:60px 0;">در حال حاضر محصول تخفیف‌داری وجود ندارد.</p>
    @endif
</div>
@endsection
