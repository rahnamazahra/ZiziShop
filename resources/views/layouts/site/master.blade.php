<!doctype html>
<html class="no-js" dir="rtl">
   <head>
        <title>@yield('title', 'گالری رهنما')</title>

        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="enamad" content="56209783" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="login-url" content="{{ route('auth.login.form') }}">
        <meta name="is-auth" content="{{ auth()->check() ? '1' : '0' }}">

        @include('layouts.site.styles')

        @yield('customStyle')

    </head>

<body>
    @include('layouts.site.pre-loader')
    @include('layouts.site.header')
    @include('layouts.site.offcanvas-area')
    @include('layouts.site.mobile-menu')
    @include('layouts.site.cart-mini')

    <main>
        @yield('content')
    </main>

    @include('layouts.site.footer')
    @include('layouts.site.scripts')
    @yield('customScript')
</body>
</html>
