@extends('layouts.panel.master')

@section('title', 'کوپن تخفیف')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'کوپن' => route('admin.vouchers.index')]" title='کوپن' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>
            <x-panel.card-title></x-panel.card-title>
            <x-panel.card-toolbar>
                <x-form.btn-a :href="route('admin.vouchers.create')" class="btn-primary" title="ایجاد کوپن جدید">
                    ایجاد کوپن جدید
                </x-form.btn-a>
            </x-panel.card-toolbar>
        </x-panel.card-header>

        <x-panel.card-body>
            <x-table>
                <x-tr>
                    <x-th>ردیف</x-th>
                    <x-th>کد</x-th>
                    <x-th>تخفیف</x-th>
                    <x-th>محصول / کاربر</x-th>
                    <x-th>تاریخ پایان</x-th>
                    <x-th>تعداد باقی</x-th>
                    <x-th>پیامک</x-th>
                    <x-th>اقدامات</x-th>
                </x-tr>

                @forelse ($vouchers as $voucher)
                    <x-tr>
                        <x-td>{{ $loop->iteration }}</x-td>

                        <x-td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $voucher->code }}</span>
                        </x-td>

                        <x-td>
                            @if($voucher->amount)
                                <span class="text-gray-800 fs-4 fw-bolder">{{ number_format($voucher->amount) }} تومان</span>
                            @else
                                <span class="text-gray-800 fs-4 fw-bolder">{{ $voucher->discount_percent }}%</span>
                            @endif
                        </x-td>

                        <x-td>
                            <span class="text-gray-600 fs-7">
                                @if($voucher->product)
                                    📦 {{ $voucher->product->name }}
                                @else
                                    همه محصولات
                                @endif
                                <br>
                                @if($voucher->user)
                                    👤 {{ $voucher->user->name }} ({{ $voucher->user->mobile }})
                                @else
                                    همه کاربران
                                @endif
                            </span>
                        </x-td>

                        <x-td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $voucher->end_date ?: '—' }}</span>
                        </x-td>

                        <x-td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $voucher->remaining }}</span>
                        </x-td>

                        <x-td>
                            @if($voucher->sms_sent)
                                <span class="badge badge-light-success fs-7">ارسال شد</span>
                            @else
                                <span class="badge badge-light-warning fs-7">ارسال نشده</span>
                            @endif
                        </x-td>

                        <x-td>
                            <div class="d-flex flex-wrap gap-1">
                                {{-- ارسال پیامک --}}
                                <form method="POST" action="{{ route('admin.vouchers.send-sms', $voucher) }}"
                                      onsubmit="return confirm('پیامک کد تخفیف ارسال شود؟')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-light-primary"
                                            title="{{ $voucher->user ? 'ارسال برای کاربر' : 'ارسال برای همه کاربران' }}">
                                        📨 پیامک
                                    </button>
                                </form>

                                {{-- اعمال تخفیف در سایت — فقط برای کوپن‌های درصدی با محصول مشخص --}}
                                @if($voucher->product_id && $voucher->discount_percent)
                                    <form method="POST" action="{{ route('admin.vouchers.apply-to-site', $voucher) }}"
                                          onsubmit="return confirm('تخفیف {{ $voucher->discount_percent }}٪ مستقیماً روی محصول «{{ $voucher->product->name }}» اعمال شود؟')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-light-success" title="نمایش قیمت خط‌خورده در سایت بدون کد کوپن">
                                            🏷️ اعمال در سایت
                                        </button>
                                    </form>
                                @endif

                                {{-- عملیات استاندارد --}}
                                <x-form method="DELETE" :action="route('admin.vouchers.destroy', $voucher)">
                                    <x-delete-button />
                                </x-form>
                                <x-detail-button :href="route('admin.vouchers.show', $voucher)"/>
                                <x-edit-button :href="route('admin.vouchers.edit', $voucher)"/>
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
           <x-panel.paginate :links="$vouchers" />
        </x-panel.card-footer>
    </x-panel.card>
@endsection
