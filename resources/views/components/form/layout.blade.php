<form method="{{ $method === 'GET' ? 'GET' : 'POST'  }}" action="{{ $route }}">
    @if($method != "GET")
        @csrf
        @method($method)
    @endif
    {{ $slot }}
</form>
