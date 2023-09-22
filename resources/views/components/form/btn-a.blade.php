@props(['route', 'title'])

<a href="{{ $route }}" {{ $attributes->merge(['class' => "btn btn-sm"]) }} data-bs-toggle="tooltip" data-bs-placement="bottom" title={{ $title }}>
    {{ $slot }}
</a>

