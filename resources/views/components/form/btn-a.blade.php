@props(['href', 'title'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => "btn btn-sm me-1"]) }} data-bs-toggle="tooltip" data-bs-placement="bottom" title={{ $title }}>
    {{ $slot }}
</a>

