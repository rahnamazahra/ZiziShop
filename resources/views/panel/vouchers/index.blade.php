@extends('layouts.panel.master')

@section('title', 'کوپن تخفیف')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'کوپن' => route('admin.vouchers.index')]" title='کوپن' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>

            <x-panel.card-title>
            </x-panel.card-title>

            <x-panel.card-toolbar>
                <x-form.btn-a :href="route('admin.vouchers.create')" class="btn-primary" title="ایجاد کوپن جدید">
                    ایجاد کوپن جدید
                </x-form.btn-a>
            </x-panel.card-toolbar>

        </x-panel.card-header>

        <x-panel.card-body>
            <x-table>
                <x-tr>
                    <x-th>کد</x-th>
                    <x-th>تخفیف</x-th>
                    <x-th>توضیحات</x-th>
                    <x-th>تاریخ شروع </x-th>
                    <x-th>تاریخ پایان </x-th>
                    <x-th>حداکثر تخفیف پست</x-th>
                    <x-th>حداقل مبلغ خرید</x-th>
                    <x-th>حداکثر مبلغ تخفیف</x-th>
                    <x-th>تعداد</x-th>
                    <x-th>اقدامات</x-th>
                </x-tr>

                 @forelse ($vouchers as $voucher)
                    <x-tr>
                        <x-td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $voucher->code }}</span>
                        </x-td>

                        <x-td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $voucher->discount }} %</span>
                        </x-td>

                        <x-td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $voucher->comment }}</span>
                        </x-td>

                        <x-td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $voucher->start_date }}</span>
                        </x-td>

                        <x-td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $voucher->end_date }}</span>
                        </x-td>

                        <x-td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $voucher->shipping_discount }}</span>
                        </x-td>

                        <td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $voucher->mininum_purchase_total }}</span>
                        </td>

                        <td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $voucher->maximum_discount }}</span>
                        </td>

                        <td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $voucher->remaining }}</span>
                        </td>

                        <x-td>
                            <div class="btn-group me-2" role="group" aria-label="First group">
                                <x-form method="DELETE" :action="route('admin.vouchers.destroy', $voucher)">
                                    <x-delete-button />
                                </x-form>

                                <x-edit-button :href="route('admin.vouchers.edit', $voucher)"/>
                            </div>
                        </x-td>
                    </x-tr>
                @empty
                    <x-tr>
                        <x-td colspan="10">آیتمی برای نمایش وجود ندارد.</x-td>
                    </x-tr>
                @endforelse
            </x-table>
        </x-panel.card-body>

        <x-panel.card-footer>
           <x-panel.paginate :links="$vouchers" />
        </x-panel.card-footer>

    </x-panel.card>


@endsection
