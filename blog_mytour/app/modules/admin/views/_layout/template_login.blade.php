<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>{{{ $title or 'Login Page' }}}</title>
	@include('admin::_partial.head')
	{{ HTML::script('backend/assets/js/jquery.validate.min.js') }}
</head>
<body>
<!-- Start #body -->
<div id="body">
	<!-- Start #login -->
	<div id="login">
			@yield('main')
	</div>
	<div class="clrb"></div>
	<footer>
		@include('admin::_partial.footer')
	</footer>
</div>

</body>
</html>
