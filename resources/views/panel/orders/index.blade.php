@extends('layouts.panel.master')

@section('title', 'سفارشات')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'سفارشات' => route('admin.orders.index')]" title='سفارشات' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>
            <x-panel.card-title>
                <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex align-items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="جست‌وجو: شماره سفارش، نام، موبایل، کد رهگیری" style="min-width:280px;">
                    <button type="submit" class="btn btn-sm btn-primary">جست‌وجو</button>
                    @if(request('search'))
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light">حذف</a>
                    @endif
                </form>
            </x-panel.card-title>
            <x-panel.card-toolbar>
            </x-panel.card-toolbar>
        </x-panel.card-header>

        <x-panel.card-body>
            <x-table>
                <x-tr>
                    <x-th>#</x-th>
                    <x-th>نام مشتری</x-th>
                    <x-th>شماره تلفن</x-th>
                    <x-th>تعداد اقلام</x-th>
                    <x-th>کد رهگیری پستی</x-th>
                    <x-th>زمان سفارش</x-th>
                    <x-th>مبلغ فاکتور</x-th>
                    <x-th>اقدامات</x-th>
                </x-tr>

                @forelse ($orders as $order)

                    <x-tr>
                        <x-td>{{ $order->id }}</x-td>

                        <x-td>
                            <span class="text-gray-800 fw-bolder">{{ optional($order->user)->name ?? '—' }}</span>
                        </x-td>

                        <x-td dir="ltr">{{ optional($order->user)->mobile ?? '—' }}</x-td>

                        <x-td>{{ $order->products->sum('pivot.count') }}</x-td>

                        <x-td dir="ltr">
                            @if($order->postal_tracking)
                                <span class="badge badge-light-info">{{ $order->postal_tracking }}</span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </x-td>

                        <x-td>{{ gdatetime($order->created_at) }}</x-td>

                        <x-td>{{ toman($order->total) }}</x-td>

                        <x-td>
                            <div class="btn-group me-2" role="group">
                                <x-form method="DELETE" :action="route('admin.orders.destroy', $order)">
                                    <x-delete-button />
                                </x-form>

                                <x-detail-button :href="route('admin.orders.show', $order)"/>
                            </div>
                        </x-td>
                    </x-tr>

                @empty

                    <x-tr>
                        <x-td colspan="8">آیتمی برای نمایش وجود ندارد.</x-td>
                    </x-tr>

                @endforelse

            </x-table>
        </x-panel.card-body>

        <x-panel.card-footer>
           <x-panel.paginate :links="$orders" />
        </x-panel.card-footer>

    </x-panel.card>


@endsection
