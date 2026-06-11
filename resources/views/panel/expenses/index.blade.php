@extends('layouts.panel.master')

@section('title', 'حسابداری و هزینه‌ها')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'هزینه‌ها' => route('admin.expenses.index')]" title='حسابداری و هزینه‌ها' />
@endsection

@section('content')
    <div class="row g-5 mb-5">
        <div class="col-md-6">
            <div class="card bg-danger h-100"><div class="card-body text-white">
                <div class="fs-6 opacity-75">جمع کل هزینه‌های ثبت‌شده</div>
                <div class="fs-2hx fw-bold">{{ toman($totalAll) }}</div>
            </div></div>
        </div>
        <div class="col-md-6">
            <div class="card bg-info h-100"><div class="card-body text-white">
                <div class="fs-6 opacity-75">هزینه‌ی ماهانه‌ی معادل (برای پس‌انداز)</div>
                <div class="fs-2hx fw-bold">{{ toman($monthlyEstimate) }}</div>
                <div class="fs-8 opacity-75 mt-1">پیشنهاد: هفتگی حدود {{ toman((int) round($monthlyEstimate / 4)) }} کنار بگذارید.</div>
            </div></div>
        </div>
    </div>

    <x-panel.card>
        <x-panel.card-header>
            <x-panel.card-title>
                <form method="GET" class="d-flex align-items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="جست‌وجوی عنوان" style="min-width:200px;">
                    <select name="type" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width:160px;">
                        <option value="">همه انواع</option>
                        @foreach($types as $t)
                            <option value="{{ $t->value }}" @selected(request('type') === $t->value)>{{ $t->label() }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-primary">جست‌وجو</button>
                </form>
            </x-panel.card-title>
            <x-panel.card-toolbar>
                <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary">ثبت هزینه جدید</a>
            </x-panel.card-toolbar>
        </x-panel.card-header>

        <x-panel.card-body>
            <x-table>
                <x-tr>
                    <x-th>عنوان</x-th>
                    <x-th>نوع</x-th>
                    <x-th>مبلغ</x-th>
                    <x-th>تاریخ</x-th>
                    <x-th>تناوب</x-th>
                    <x-th>جزئیات</x-th>
                    <x-th>اقدامات</x-th>
                </x-tr>

                @forelse($expenses as $expense)
                    <x-tr>
                        <x-td class="fw-bold">{{ $expense->title }} @if($expense->is_demo)<span class="badge badge-light-warning ms-1">تستی</span>@endif</x-td>
                        <x-td>{{ $expense->type->label() }}</x-td>
                        <x-td>{{ toman($expense->amount) }}</x-td>
                        <x-td>{{ gdate($expense->spent_at) }}</x-td>
                        <x-td>{{ \App\Models\Expense::RECURRENCES[$expense->recurrence] ?? $expense->recurrence }}</x-td>
                        <x-td class="fs-8 text-gray-600">
                            @if($expense->material_name)متریال: {{ $expense->material_name }} @endif
                            @if($expense->product_code) | کد: {{ $expense->product_code }} @endif
                            @if($expense->quantity) | تعداد: {{ $expense->quantity }} @endif
                            @if($expense->weight) | وزن: {{ $expense->weight }}گرم @endif
                        </x-td>
                        <x-td>
                            <div class="btn-group" role="group">
                                <x-form method="DELETE" :action="route('admin.expenses.destroy', $expense)">
                                    <x-delete-button />
                                </x-form>
                                <x-edit-button :href="route('admin.expenses.edit', $expense)"/>
                            </div>
                        </x-td>
                    </x-tr>
                @empty
                    <x-tr>
                        <x-td colspan="7">هنوز هزینه‌ای ثبت نشده است.</x-td>
                    </x-tr>
                @endforelse
            </x-table>
        </x-panel.card-body>

        <x-panel.card-footer>
            <x-panel.paginate :links="$expenses" />
        </x-panel.card-footer>
    </x-panel.card>
@endsection
