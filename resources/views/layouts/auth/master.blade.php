<!DOCTYPE html>
<html lang="fa" dir="rtl">
	<head>
		<title> زی زی شاپ - @yield('title')</title>

		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="زی زی شاپ - احرازهویت" />

        <link rel="shortcut icon" href="{{ asset('/images/logo/logo.png') }}" />

		<link rel="stylesheet" href="{{ asset('panel/assets/plugins/global/fonts/yekan-perrsian-numeral/font.css') }}" />

		<link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/plugins/global/plugins.bundle.rtl.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('panel/assets/css/style.bundle.rtl.css') }}" />

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
