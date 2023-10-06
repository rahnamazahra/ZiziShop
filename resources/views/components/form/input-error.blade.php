@props(['messages'])

@if ($messages)
    <x-panel.ul {{ $attributes->merge(['class' => 'text-sm text-danger space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <x-panel.li>{{ $message }}</x-panel.li>
        @endforeach
    </x-panel.ul>
@endif
