<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>MCHostExposed :: {{ $title }}</title>
	<link rel="stylesheet" href="http://mchostexposed.com/css/style.css" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="nav">
		<div class="container">
			{{ HTML::link('/', 'MCHostExposed', array('id' => 'logo')) }}
			<ul>
				<li>{{ HTML::link('/', 'Home') }}</li>
				<li>{{ HTML::link('/list', 'Listing') }}</li>
				<li>{{ HTML::link('/request', 'Request Rating') }}</li>
				<li>{{ HTML::link('/about', 'About') }}</li>
			</ul>
			<div class="clear"></div>
		</div>
	</div>
	
	@yield('content')

	<div class="container" id="footer">
		Copyright (c) 2013 MCHostExposed. Information on this site is correct to the best of our knowledge, but we make no guarantees of its accuracy.<br>
		This site is not affiliated with any hosting provider.
	</div>
	@if (isset($addendum))
	@include($addendum)
	@endif
	@include ('layouts.scripts')
</body>
</html>
