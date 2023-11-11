<!doctype html>
<html class="no-js" dir="rtl">
   <head>
        <title>@yield('title')</title>

        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @include('layouts.site.styles')

        @yield('customStyle')

    </head>

<body>
    @include('layouts.site.pre-loader')
    @include('layouts.site.back-to-top')
    @include('layouts.site.offcanvas-area')
    @include('layouts.site.mobile-menu')
    @include('layouts.site.search-area')
    @include('layouts.site.cart-mini')
    <x-header/>

    <main>
        @yield('content')
    </main>

    @include('layouts.site.footer')
    @include('layouts.site.scripts')
    @yield('customScript')
</body>
</html>
