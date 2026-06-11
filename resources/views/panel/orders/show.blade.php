@extends('layouts.panel.master')

@section('title', 'فاکتور سفارش')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'سفارشات' => route('admin.orders.index'), 'فاکتور' => '#']" title='فاکتور سفارش' />
@endsection

@section('content')
    <div>
        {{-- فرم ثبت کد رهگیری پستی --}}
        <x-panel.card class="mb-5">
            <x-panel.card-body>
                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" class="row align-items-end g-3">
                    @csrf
                    @method('PUT')
                    <div class="col-md-7">
                        <label class="form-label fw-bold">کد رهگیری پستی</label>
                        <input type="text" name="postal_tracking" class="form-control" value="{{ $order->postal_tracking }}" placeholder="کد رهگیری ۲۴ رقمی مرسوله" dir="ltr">
                    </div>
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-primary w-100">ثبت و اطلاع‌رسانی پیامکی</button>
                    </div>
                </form>
            </x-panel.card-body>
        </x-panel.card>

        @include('partials.order-invoice', ['order' => $order, 'isAdmin' => true])

        <div class="text-center mt-5">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-light">بازگشت به لیست</a>
        </div>
    </div>
@endsection
