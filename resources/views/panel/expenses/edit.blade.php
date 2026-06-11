@extends('layouts.panel.master')

@section('title', 'ویرایش هزینه')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'هزینه‌ها' => route('admin.expenses.index'), 'ویرایش' => '#']" title='ویرایش هزینه' />
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.expenses.update', $expense) }}">
        @csrf
        @method('PUT')
        <x-panel.card>
            <x-panel.card-header>
                <x-panel.card-title><x-panel.heading level="2">ویرایش هزینه</x-panel.heading></x-panel.card-title>
            </x-panel.card-header>
            <x-panel.card-body>
                @include('panel.expenses._form')
            </x-panel.card-body>
            <x-panel.card-footer>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.expenses.index') }}" class="btn btn-light">لغو</a>
                    <button type="submit" class="btn btn-primary">ذخیره</button>
                </div>
            </x-panel.card-footer>
        </x-panel.card>
    </form>
@endsection
