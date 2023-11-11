<!doctype html>
<html class="no-js" lang="zxx">
    <head>

        <title>پنل‌مدیریت - @yield('title')</title>

        <meta charset="utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:locale" content="fa" />
        <meta property="og:type" content=""/>
        <meta property="og:title" content=""/>
        <meta property="og:url" content=""/>
        <meta property="og:site_name" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @include('layouts.panel.styles')

        @yield('custom-style')

    </head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" data-kt-app-layout="light-sidebar" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">

    <div class="d-flex flex-column flex-root">
		<div class="page d-flex flex-row flex-column-fluid">

            @include('layouts.panel.sidebar')

            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

				@include('layouts.panel.header')

                <div class="toolbar" id="kt_toolbar">
					<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
						<div data-kt-swapper="true" data-kt-swapper-mode="prepend" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
							@yield('breadcrumb')
						</div>
					</div>
				</div>

				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<div class="post d-flex flex-column-fluid" id="kt_post">
						<div id="kt_content_container" class="container-xxl">
							@yield('content')
						</div>
					</div>
				</div>

                <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
                    <span class="svg-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor"></rect>
                            <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor"></path>
                        </svg>
                    </span>
                </div>

				@include('layouts.panel.footer')

			</div>
		</div>
	</div>

    @include('layouts.panel.scripts')

	@include('layouts.panel.alert')

    @yield('custom-scripts')

</body>
</html>
