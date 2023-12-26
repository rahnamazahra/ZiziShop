@extends('layouts.panel.master')

@section('title', 'سفارشات')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'سفارشات' => route('admin.orders.index')]" title='سفارشات' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>
            <x-panel.card-title>
            </x-panel.card-title>
            <x-panel.card-toolbar>
            </x-panel.card-toolbar>
        </x-panel.card-header>

        <x-panel.card-body>
            <x-table>
                <x-tr>
                    <x-th>وضعیت</x-th>
                    <x-th>نام مشتری</x-th>
                    <x-th>شماره تلفن مشتری</x-th>
                    <x-th>آدرس پستی</x-th>
                    <x-th>زمان سفارش</x-th>
                    <x-th>مبلغ فاکتور</x-th>
                    <x-th>اقدامات</x-th>
                </x-tr>

                @forelse ($orders as $order)

                    <x-tr>
                        <x-td>
                            
                        </x-td>

                        <x-td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $order->user->name }}</span>
                        </x-td>

                        <x-td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $order->created_at }}</span>
                        </x-td>

                        <x-td>

                            <div class="btn-group me-2" role="group" aria-label="First group">

                                <x-form method="DELETE" :action="route('admin.orders.destroy', $order)">
                                    <x-delete-button />
                                </x-form>

                                <x-edit-button :href="route('admin.orders.edit', $order)"/>


                            </div>
                        </x-td>
                    </x-tr>

                @empty

                    <x-tr>
                        <x-td colspan="6">آیتمی برای نمایش وجود ندارد.</x-td>
                    </x-tr>

                @endforelse

            </x-table>
        </x-panel.card-body>

        <x-panel.card-footer>
           <x-panel.paginate :links="$orders" />
        </x-panel.card-footer>

    </x-panel.card>


@endsection
