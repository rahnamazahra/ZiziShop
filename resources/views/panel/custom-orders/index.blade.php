@extends('layouts.panel.master')

@section('title', 'سفارش‌های ویژه')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'سفارش‌های ویژه' => route('admin.custom-orders.index')]" title='سفارش‌های ویژه' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>
            <x-panel.card-title>
                <form method="GET" class="d-flex align-items-center gap-2">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">همه وضعیت‌ها</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </form>
            </x-panel.card-title>
            <x-panel.card-toolbar></x-panel.card-toolbar>
        </x-panel.card-header>

        <x-panel.card-body>
            <x-table>
                <x-tr>
                    <x-th>ردیف</x-th>
                    <x-th>محصول</x-th>
                    <x-th>مشتری</x-th>
                    <x-th>تماس</x-th>
                    <x-th>تعداد</x-th>
                    <x-th>قیمت کل</x-th>
                    <x-th>وضعیت</x-th>
                    <x-th>تاریخ</x-th>
                    <x-th>اقدامات</x-th>
                </x-tr>

                @forelse ($orders as $order)
                    <x-tr>
                        <x-td>{{ $loop->iteration }}</x-td>
                        <x-td>
                            <span class="text-gray-800 fw-bold">{{ $order->product->name ?? '—' }}</span>
                        </x-td>
                        <x-td>{{ $order->contact_name ?: ($order->user->name ?? 'مهمان') }}</x-td>
                        <x-td>{{ $order->contact_mobile }}</x-td>
                        <x-td>{{ $order->quantity }}</x-td>
                        <x-td>{{ $order->unit_price ? number_format($order->total).' ت' : '—' }}</x-td>
                        <x-td>
                            <span class="badge {{ $order->status->badgeClass() }}">{{ $order->status->label() }}</span>
                        </x-td>
                        <x-td>{{ gdate($order->created_at) }}</x-td>
                        <x-td>
                            <a href="{{ route('admin.custom-orders.show', $order) }}" class="btn btn-sm btn-light-primary">
                                بررسی
                            </a>
                        </x-td>
                    </x-tr>
                @empty
                    <x-tr>
                        <x-td colspan="9">آیتمی برای نمایش وجود ندارد.</x-td>
                    </x-tr>
                @endforelse
            </x-table>
        </x-panel.card-body>

        <x-panel.card-footer>
            <x-panel.paginate :links="$orders" />
        </x-panel.card-footer>
    </x-panel.card>
@endsection
