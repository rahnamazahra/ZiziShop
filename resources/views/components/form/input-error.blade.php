@props(['messages'])

@if ($messages)
    <x-panel.ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <x-panel.li>{{ $message }}</x-panel.li>
        @endforeach
    </x-panel.ul>
@endif
