<form method="{{ $method }}" action="{{ $route }}">
    @if($method == "POST")
        @csrf
    @endif
    {{ $slot }}
</form>
