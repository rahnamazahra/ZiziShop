<!DOCTYPE html>
<html lang="fa" dir="rtl">
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
	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<div class="page d-flex flex-row flex-column-fluid">
			<!--begin::Aside-->
			@include('layouts.panel.sidebar')
			<!--end::Aside-->
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<!--begin::Header-->
				@include('layouts.panel.header')
				<!--begin::breadcrumb-->
				<div class="toolbar" id="kt_toolbar">
					<!--begin::Container-->
					<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
						<!--begin::Page title-->
						<div data-kt-swapper="true" data-kt-swapper-mode="prepend" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
							@yield('breadcrumb')
						</div>
						<!--end::Page title-->
					</div>
					<!--end::Container-->
				</div>
				<!--end::breadcrumb-->
				<!--end::Header-->
				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<div class="post d-flex flex-column-fluid" id="kt_post">
						<div id="kt_content_container" class="container-xxl">
							@yield('content')
						</div>
					</div>
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				@include('layouts.panel.footer')
				<!--end::Footer-->
			</div>
		</div>
	</div>
	<!--begin::Javascript-->
	@include('layouts.panel.scripts')
	@include('layouts.panel.alert')
    @yield('custom-scripts')
	<!--end::Javascript-->
</body>
</html>
