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

                <x-form.btn type="button" class="btn-outline btn-outline-light btn-active-light" title="فیلتر" data-bs-toggle="collapse" data-bs-target="#filter_search">
                    <x-svg.icon-svg icon='filter' />
                </x-form.btn>

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

            <x-panel.div-section id="filter_search" class="flex collapse">
                <x-form method="GET" :action="route('admin.users.index')">
                    <x-panel.div-section class="row mb-8">

                        <x-panel.div-section class="col-md-2 fv-row">
                            <x-panel.div-section class="d-flex align-items-center fw-bolder" data-select2-id="select2-data-122-u471">
                                <x-panel.div-section class="text-gray-400 fs-7 me-2">شهر</x-panel.div-section>

                                <select name="city" id="city" class="form-select form-select-transparent text-graY-800 fs-base lh-1 fw-bolder py-0 ps-3 w-auto select2-hidden-accessible" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px" data-placeholder="لطفا انتخاب کنید" tabindex="-1" aria-hidden="true">
                                    <option value="all" @selected(! request()->filled('city')) value=" ">همه</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}" @selected (request()->query('city') == $city->id)> {{ $city->name }} </option>
                                    @endforeach
                                </select>

                            </x-panel.div-section>
                        </x-panel.div-section>

                        <x-panel.div-section class="col-md-2 fv-row">
                            <x-panel.div-section class="d-flex align-items-center fw-bolder" data-select2-id="select2-data-122-u471">
                                <x-panel.div-section class="text-gray-400 fs-7 me-2">استان</x-panel.div-section>

                                <select name="province" id="province" class="form-select form-select-transparent text-graY-800 fs-base lh-1 fw-bolder py-0 ps-3 w-auto select2-hidden-accessible" data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px" data-placeholder="همه" tabindex="-1" aria-hidden="true">
                                    <option value="all" @selected (! request()->filled('province')) value=" ">همه</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}" @selected (request()->query('province') == $province->id)> {{ $province->name }} </option>
                                    @endforeach
                                </select>

                            </x-panel.div-section>
                        </x-panel.div-section>

                        <x-panel.div-section class="col-md-1">
                            <x-form.btn type="submit" class="btn btn-sm btn-primary" title="جست‌وجو">جست‌و‌جو</x-form.btn>
                        </x-panel.div-section>

                    </x-panel.div-section>
                </x-form>
            </x-panel.div-section>

            <x-table>
                <x-tr>
                    <x-th>ردیف</x-th>
                    <x-th>نام</x-th>
                    <x-th>شماره‌تلفن</x-th>
                    <x-th>استان</x-th>
                    <x-th>شهر</x-th>
                    <x-th>اقدامات</x-th>
                </x-tr>


                @forelse ($users as $user)

                    <x-tr>
                        <x-td>{{ $user->id ?? '-' }}</x-td>
                        <x-td>{{ $user->name ?? '-' }}</x-td>
                        <x-td>{{ $user->mobile ?? '-' }}</x-td>
                        <x-td>{{ $user->province->name ?? '-' }}</x-td>
                        <x-td>{{ $user->city->name ?? '-' }}</x-td>

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

                                <x-edit-button :href="route('admin.users.edit', $user)"/>

                            @endif

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
           <x-panel.paginate :links="$users" />
        </x-panel.card-footer>

    </x-panel.card>
@endsection
