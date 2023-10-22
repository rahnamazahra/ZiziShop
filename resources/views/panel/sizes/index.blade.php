@extends('layouts.panel.master')

@section('title', 'سایز')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'سایز' => route('admin.sizes.index')]" title='سایز' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>

            <x-panel.card-title>
            </x-panel.card-title>

            <x-panel.card-toolbar>

                <x-form.btn-a :href="route('admin.sizes.create')" class="btn-primary" title="ایجاد سایز جدید">
                    ایجاد سایز جدید
                </x-form.btn-a>

            </x-panel.card-toolbar>
        </x-panel.card-header>

        <x-panel.card-body>
            <x-table>
                <x-tr>
                    <x-th>نام</x-th>
                    <x-th>اقدامات</x-th>
                </x-tr>


                @forelse ($sizes as $size)

                    <x-tr>
                        <x-td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $size->name ?? '-' }}</span>
                        </x-td>

                        <x-td>

                            <div class="btn-group me-2" role="group" aria-label="First group">

                                <x-form method="DELETE" :action="route('admin.sizes.destroy', $size)">
                                    <x-delete-button />
                                </x-form>

                                <x-edit-button :href="route('admin.sizes.edit', $size)"/>


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
           <x-panel.paginate :links="$sizes" />
        </x-panel.card-footer>

    </x-panel.card>


@endsection
