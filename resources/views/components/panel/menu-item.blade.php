@props(['href', 'icon', 'title'])

<x-panel.div-section class="menu-item">
    <a href="{{ $href }}" class="menu-link {{ Request::routeIs('$route') ? 'active' : '' }}">
        <x-panel.span class="menu-icon">
            <x-svg.icon-svg icon='{{ $icon }}' class="svg-icon-2"/>
        </x-panel.span>
        <x-panel.span class="menu-title">{{ $title }}</x-panel.span>
    </a>
</x-panel.div-section>
