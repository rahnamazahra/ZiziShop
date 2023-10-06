<form method="{{ $method === 'GET' ? 'GET' : 'POST'  }}" action="{{ $action }}" {{ $attributes }}>
    @if($method != "GET")
        @csrf
        @method($method)
    @endif
    {{ $slot }}
</form>
