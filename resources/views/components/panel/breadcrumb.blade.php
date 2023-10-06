@aware(['breadcrumb', 'title'])

<x-panel.heading level="1" class="d-flex text-dark fs-3 ax-panel.lign-items-center my-1">
    {{ $title }}
</x-panel.heading>

<x-panel.span class="h-20px border-gray-300 border-start mx-4"></x-panel.span>

<x-panel.ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">

    @foreach ($breadcrumb as $label => $route)

        @if ($loop->last)
            <x-panel.li class="breadcrumb-item text-dark">{{ $label }}</x-panel.li>
        @else

            <x-panel.li class="breadcrumb-item text-muted">
                <x-panel.link href="{{ $route }}" class="text-muted text-hover-primary">
                    {{ $label }}
                </x-panel.link>
            </x-panel.li>

            <x-panel.li class="breadcrumb-item">
                <x-panel.span class="bullet bg-gray-300 w-5px h-2px"></x-panel.span>
            </x-panel.li>

        @endif

    @endforeach
</x-panel.ul>
