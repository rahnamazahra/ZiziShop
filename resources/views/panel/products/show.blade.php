@extends('layouts.panel.master')

@section('title', 'جزئیات محصول: ' . $product->name)

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="$breadcrumb" :title="$product->name" />
@endsection

@section('content')

{{-- ═══ تحلیل سود — بالاترین بخش ═══ --}}
@php
    $profitColor = $profit['profit'] >= 0 ? 'success' : 'danger';
@endphp
<div class="row g-4 mb-6">
    <div class="col-6 col-md-3">
        <div class="card card-flush h-100">
            <div class="card-body py-4 px-5">
                <div class="fs-8 text-gray-500 mb-1">قیمت تمام‌شده (واحد)</div>
                <div class="fs-3 fw-bold text-primary">{{ number_format($product->cost_price) }} <small class="fs-7">ت</small></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-flush h-100">
            <div class="card-body py-4 px-5">
                <div class="fs-8 text-gray-500 mb-1">تعداد فروخته‌شده</div>
                <div class="fs-3 fw-bold text-info">{{ number_format($profit['units']) }} <small class="fs-7">عدد</small></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-flush h-100">
            <div class="card-body py-4 px-5">
                <div class="fs-8 text-gray-500 mb-1">درآمد کل</div>
                <div class="fs-3 fw-bold text-warning">{{ number_format($profit['revenue']) }} <small class="fs-7">ت</small></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-flush h-100 border-{{ $profitColor }}">
            <div class="card-body py-4 px-5">
                <div class="fs-8 text-gray-500 mb-1">سود ناخالص <span class="badge badge-light-{{ $profitColor }} ms-1">{{ $profit['margin'] }}%</span></div>
                <div class="fs-3 fw-bold text-{{ $profitColor }}">{{ number_format($profit['profit']) }} <small class="fs-7">ت</small></div>
            </div>
        </div>
    </div>
</div>
<div class="text-muted fs-8 mb-6">* هزینه‌ی پست در سطح سفارش محاسبه می‌شود و در سود تک‌محصول لحاظ نشده است.</div>

{{-- ═══ نمودار فروش ماهانه ═══ --}}
@if(count($chartMonths) > 0)
<div class="card mb-6">
    <div class="card-header">
        <div class="card-title fw-bold">📈 فروش ماهانه (۱۲ ماه اخیر)</div>
    </div>
    <div class="card-body">
        <div id="gr-product-chart" style="height:220px;"></div>
    </div>
</div>
@endif

{{-- ═══ کارت اصلی: عکس‌ها + جزئیات ═══ --}}
<x-panel.card>
    <x-panel.card-header>
        <x-panel.card-title>
            <x-panel.heading level="2">{{ $product->name }}</x-panel.heading>
        </x-panel.card-title>
        <x-panel.card-toolbar>
            <a href="{{ $editUrl }}" class="btn btn-light-primary btn-sm">ویرایش</a>
            <a href="{{ $backUrl }}" class="btn btn-light btn-sm">بازگشت</a>
        </x-panel.card-toolbar>
    </x-panel.card-header>

    <x-panel.card-body>
        {{-- عکس‌ها --}}
        @if($product->images->isNotEmpty())
            <div class="d-flex flex-wrap gap-3 mb-6">
                @foreach($product->images as $media)
                    <div style="width:130px;">
                        @if($media->type === 'video')
                            <video src="{{ $media->url }}" controls style="width:100%;height:100px;object-fit:cover;border-radius:8px;"></video>
                        @else
                            <img src="{{ $media->url }}" style="width:100%;height:100px;object-fit:cover;border-radius:8px;" alt="">
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        {{-- جدول جزئیات --}}
        <table class="table table-row-dashed gy-3 align-middle">
            <tbody>
                @foreach($items as $label => $value)
                    <tr>
                        <td class="fw-bold text-gray-600" style="width:200px;">{{ $label }}</td>
                        <td>{!! $value !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-panel.card-body>
</x-panel.card>

@endsection

@section('custom-scripts')
@if(count($chartMonths) > 0)
<script>
(function () {
    const el = document.getElementById('gr-product-chart');
    if (!el || typeof ApexCharts === 'undefined') return;

    new ApexCharts(el, {
        series: [
            { name: 'تعداد فروش', type: 'bar', data: @json($chartUnits) },
            { name: 'درآمد (تومان)', type: 'line', data: @json($chartRevenue) },
        ],
        chart: {
            height: 220, fontFamily: 'inherit',
            toolbar: { show: false },
        },
        stroke: { width: [0, 3], curve: 'smooth' },
        colors: ['#343265', '#f59e0b'],
        xaxis: { categories: @json($chartMonths), labels: { style: { fontSize: '11px' } } },
        yaxis: [
            { title: { text: 'تعداد' }, labels: { formatter: v => Math.round(v) } },
            { opposite: true, title: { text: 'درآمد' }, labels: { formatter: v => (v/1000).toFixed(0) + 'ک' } },
        ],
        tooltip: { y: [{ formatter: v => v + ' عدد' }, { formatter: v => Number(v).toLocaleString() + ' ت' }] },
        legend: { position: 'top' },
        plotOptions: { bar: { borderRadius: 4 } },
        dataLabels: { enabled: false },
    }).render();
})();
</script>
@endif
@endsection
