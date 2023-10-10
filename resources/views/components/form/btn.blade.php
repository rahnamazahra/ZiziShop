@props(['type', 'title'])
<button {{ $attributes->merge(['class' => "btn btn-sm"]) }} data-bs-toggle="tooltip" data-bs-placement="bottom" title={{ $title }}>
   {{ $slot }}
</button>
