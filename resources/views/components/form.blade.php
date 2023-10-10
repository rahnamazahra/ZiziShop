@props(['method', 'action'])

<form method="{{ $method === 'GET' ? 'GET' : 'POST'  }}" action="{{ $action }}" class="mx-auto w-100 fv-plugins-bootstrap5 fv-plugins-framework">
    @if($method != "GET")
        @csrf
        @method($method)
    @endif
    {{ $slot }}
</form>
