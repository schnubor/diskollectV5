<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="/images/favicon.png" />
	<meta name="robots" content="@yield('robots', 'noindex, nofollow')">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<title>@yield('title') | The Record</title>
	<meta name="description" content="@yield('description', 'TheRecord.de is bringing vinyl collectors together and allows you to maintain and analyze your collection online.')">
	<meta name="keywords" content="vinyl, record, therecord @yield('keywords')">
	<link href="/images/apple-touch-icon.png" rel="apple-touch-icon">
	<meta name="google-site-verification" content="5yzH2z3tjL4bQoC_F_vRho5xpEMYI0itj5AJR6wTaLo" />

	{{-- Social --}}
	<meta property="og:image" content="@yield('ogimage', 'https://therecord.de/images/fb_image.jpg')">
	<meta property="og:type" content="website">
	<meta property="og:title" content="@yield('title') | The Record">
	<meta property="og:description" content="@yield('description', 'therecord.de is bringing vinyl collectors together and allows you to maintain and analyze your record collection online.')">
	<meta property="og:url" content="{{ Request::url() }}">
	<meta property="og:site_name" content="therecord.de">

	{{-- Fonts --}}
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

	{{-- Styles, Scripts, etc. --}}
	<link rel="stylesheet" href="{{ elixir("css/all.css") }}">
	<link rel="stylesheet" href="/css/vendor/font-awesome.min.css">
	<meta name="csrf-token" content="<?php echo csrf_token() ?>"/>
	@if(Auth::check())
	<meta name="user-currency" content="{{ Auth::user()->currency }}"/>
	@endif

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	@include('partials.analytics')

	<div class="flash-message">
		@include('flash::message')
	</div>

	@yield('content')

	@if(Auth::check())
		<nav class="mobileNav text-center" onClick="$('.sidebar, .content-area').toggleClass('active');">
			<i class="fa fa-bars"></i>
		</nav>
	@endif

	<!-- Scripts -->
	<script src="/js/all.js"></script>
	@yield('scripts')
</body>
</html>
