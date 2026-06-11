<!DOCTYPE html>
<html lang="fa" dir="rtl">
	<head>
		<title> گالری رهنما - @yield('title')</title>

		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="گالری رهنما - احرازهویت" />

        <link rel="shortcut icon" href="{{ asset('/images/logo/logo.png') }}" />

		<link rel="stylesheet" href="{{ asset('panel/assets/plugins/global/fonts/yekan-perrsian-numeral/font.css') }}" />

		<link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/plugins/global/plugins.bundle.rtl.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/style.bundle.rtl.css') }}" />

		<style>
			body#kt_body { direction: rtl; }
			/* پالت سازمانی ایندیگو در صفحه‌ی ورود */
			.btn-primary { background-color: #343265 !important; border-color: #343265 !important; }
			.btn-primary:hover, .btn-primary:focus, .btn-primary:active { background-color: #222143 !important; border-color: #222143 !important; }
			.text-primary, a.link-primary { color: #343265 !important; }
			a.link-primary:hover { color: #527aba !important; }
			.form-control:focus { border-color: #7796c9; box-shadow: 0 0 0 .2rem rgba(52,50,101,.12); }
			@media (max-width: 575.98px) {
				.w-lg-500px { width: 100% !important; max-width: 100% !important; }
				.p-10 { padding: 1.6rem !important; }
				.pb-lg-20 { padding-bottom: 1rem !important; }
				#kt_body .fs-1, #kt_body h1 { font-size: 1.4rem !important; }
			}
		</style>

	</head>

	<body id="kt_body" class="bg-body font-iy">

        @yield('content')

		@include('layouts.panel.scripts')

        @include('layouts.panel.alert')

		<script>
			var button = document.querySelector(".btn-submit");

			button.addEventListener("click", function () {
				button.setAttribute("data-kt-indicator", "on");
				setTimeout(function () {
					button.removeAttribute("data-kt-indicator");
				}, 3000);
			});
		</script>

	</body>

</html>
