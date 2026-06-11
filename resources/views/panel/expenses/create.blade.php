@extends('layouts.panel.master')

@section('title', 'ثبت هزینه')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد'=> route('admin.dashboard'), 'هزینه‌ها' => route('admin.expenses.index'), 'ثبت هزینه' => '#']" title='ثبت هزینه جدید' />
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.expenses.store') }}">
        @csrf
        <x-panel.card>
            <x-panel.card-header>
                <x-panel.card-title><x-panel.heading level="2">ثبت هزینه جدید</x-panel.heading></x-panel.card-title>
            </x-panel.card-header>
            <x-panel.card-body>
                @include('panel.expenses._form')
            </x-panel.card-body>
            <x-panel.card-footer>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.expenses.index') }}" class="btn btn-light">لغو</a>
                    <button type="submit" class="btn btn-primary">ثبت</button>
                </div>
            </x-panel.card-footer>
        </x-panel.card>
    </form>
@endsection
