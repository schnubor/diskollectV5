<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>For the Record - @yield('title')</title>

	<link rel="stylesheet" href="{{ elixir("css/all.css") }}">
	<link rel="stylesheet" href="/css/vendor/font-awesome.min.css">
	<meta name="csrf-token" content="<?php echo csrf_token() ?>"/>
	@if(Auth::check())
	<meta name="user-currency" content="{{ Auth::user()->currency }}"/>
	@endif


	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
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
