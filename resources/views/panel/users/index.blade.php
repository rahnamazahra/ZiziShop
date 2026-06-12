@extends('layouts.panel.master')

@section('title', 'کاربران')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'کاربران' => route('admin.users.index')]" title='کاربران' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>
            <x-panel.card-title>

                <x-panel.search :action="route('admin.users.index', ['search'])" />

                @if (count(request()->query()) > 0)
                    <x-form.btn-a :href="route('admin.users.index')" class="btn-light-primary" title="حذف فیلتر">
                        حذف فیلتر
                    </x-form.btn-a>
                @endif

            </x-panel.card-title>

            <x-panel.card-toolbar>

                <x-form.btn-a :href="route('admin.users.create')" class="btn-primary" title="ایجاد کاربر جدید">
                    ایجاد کاربر جدید
                </x-form.btn-a>

                 <x-form.btn-a :href="route('admin.users.export')" class="btn-light-primary" title="Export Excel">
                    Export Excel
                    <x-svg.icon-svg icon="export" />
                </x-form.btn-a>

                @if (request()->has('trashed'))
                    <x-form.btn-a :href="route('admin.users.index')" class="btn-light" title="برگشت">
                        <x-svg.icon-svg icon="back" />
                    </x-form.btn-a>
                @else
                    <x-form.btn-a :href="route('admin.users.index', ['trashed'])" class="btn-light" title="سطل‌زباله">
                        <x-svg.icon-svg icon="delete" />
                    </x-form.btn-a>
                @endif

            </x-panel.card-toolbar>

        </x-panel.card-header>

        <x-panel.card-body>

            <x-table>
                <x-tr>
                    <x-th>ردیف</x-th>
                    <x-th>نام</x-th>
                    <x-th>موبایل</x-th>
                    <x-th>تاریخ تولد</x-th>
                    <x-th>تاریخ عضویت</x-th>
                    <x-th>تعداد سفارش</x-th>
                    <x-th>مجموع خرید</x-th>
                    <x-th>اقدامات</x-th>
                </x-tr>


                @forelse ($users as $user)

                    <x-tr>
                        <x-td>{{ $loop->iteration }}</x-td>
                        <x-td class="fw-bold">{{ $user->name ?? '-' }}</x-td>
                        <x-td dir="ltr">{{ $user->mobile ?? '-' }}</x-td>
                        <x-td>{{ $user->birthday ? gdate($user->birthday) : '—' }}</x-td>
                        <x-td>{{ gdate($user->created_at) }}</x-td>
                        <x-td>{{ number_format($user->orders_count ?? 0) }}</x-td>
                        <x-td>{{ toman($user->purchases_total ?? 0) }}</x-td>

                        <x-td>

                            <div class="btn-group me-2" role="group" aria-label="First group">

                            @if($user->trashed())
                                <x-form method="POST" :action="route('admin.users.force-delete', $user)">
                                    <x-delete-button />
                                </x-form>

                                <x-form method="PUT" :action="route('admin.users.restore', $user)">
                                    <x-restore-button />
                                </x-form>
                            @else

                                <x-form method="DELETE" :action="route('admin.users.destroy', $user)">
                                    <x-delete-button />
                                </x-form>

                                <x-detail-button :href="route('admin.users.show', $user)"/>

                                <x-edit-button :href="route('admin.users.edit', $user)"/>

                            @endif

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
           <x-panel.paginate :links="$users" />
        </x-panel.card-footer>

    </x-panel.card>
@endsection
