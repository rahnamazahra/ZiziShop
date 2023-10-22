@extends('layouts.panel.master')

@section('title', 'دسته‌بندی')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'رنگ' => route('admin.colors.index')]" title='رنگ' />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>
            
            <x-panel.card-title>
            </x-panel.card-title>

            <x-panel.card-toolbar>
                <x-form.btn-a :href="route('admin.colors.create')" class="btn-primary" title="ایجاد رنگ جدید">
                    ایجاد رنگ جدید
                </x-form.btn-a>
            </x-panel.card-toolbar>

        </x-panel.card-header>

        <x-panel.card-body>
            <x-table>
                <x-tr>
                    <x-th>نام</x-th>
                    <x-th>کد</x-th>
                    <x-th>اقدامات</x-th>
                </x-tr>

                @forelse ($colors as $color)

                    <x-tr>
                        <x-td>
                            <span class="text-gray-800 fs-4 fw-bolder">{{ $color->name }}</span>
                        </x-td>

                        <x-td>
                            <div style="background: {{ $color->code }}">
                                <span class="text-gray-800 fs-4 fw-bolder">{{ $color->code }}</span>
                            </div>
                        </x-td>

                        <x-td>

                            <div class="btn-group me-2" role="group" aria-label="First group">

                                <x-form method="DELETE" :action="route('admin.colors.destroy', $color)">
                                    <x-delete-button />
                                </x-form>

                                <x-edit-button :href="route('admin.colors.edit', $color)"/>


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
           <x-panel.paginate :links="$colors" />
        </x-panel.card-footer>

    </x-panel.card>


@endsection
