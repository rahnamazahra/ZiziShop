@extends('layouts.panel.master')

@section('title', $title ?? 'جزئیات')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="$breadcrumb ?? []" :title="$title ?? 'جزئیات'" />
@endsection

@section('content')
    <x-panel.card>
        <x-panel.card-header>
            <x-panel.card-title>
                <x-panel.heading level="2">{{ $title ?? 'جزئیات' }}</x-panel.heading>
            </x-panel.card-title>
            @if(!empty($headerExtra))
                <x-panel.card-toolbar>
                    {!! $headerExtra !!}
                </x-panel.card-toolbar>
            @endif
        </x-panel.card-header>

        <x-panel.card-body>
            @if(!empty($images))
                <div class="d-flex flex-wrap gap-3 mb-6">
                    @foreach($images as $media)
                        <div style="width:130px;">
                            @if(is_array($media) && ($media['type'] ?? 'image') === 'video')
                                <video src="{{ $media['url'] }}" controls style="width:100%;height:100px;object-fit:cover;border-radius:8px;"></video>
                            @else
                                <img src="{{ is_array($media) ? $media['url'] : $media }}" style="width:100%;height:100px;object-fit:cover;border-radius:8px;" alt="">
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <table class="table table-row-dashed gy-3 align-middle">
                <tbody>
                    @foreach($items as $label => $value)
                        <tr>
                            <td class="fw-bold text-gray-600" style="width:220px;">{{ $label }}</td>
                            <td>{!! $value !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 d-flex gap-2">
                @if(!empty($editUrl))
                    <a href="{{ $editUrl }}" class="btn btn-light-primary">ویرایش</a>
                @endif
                <a href="{{ $backUrl }}" class="btn btn-light">بازگشت به لیست</a>
            </div>
        </x-panel.card-body>
    </x-panel.card>
@endsection
