@props(['type', 'title'])
<button type="{{ $type }}" {{ $attributes->merge(['class' => "btn btn-sm"]) }} data-bs-toggle="tooltip" data-bs-placement="bottom" title={{ $title }}>
   {{ $slot }}
</button>
