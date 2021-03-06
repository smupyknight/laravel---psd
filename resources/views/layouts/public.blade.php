<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>PSD | {{ $title or '' }}</title>

	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/font-awesome/css/font-awesome.css" rel="stylesheet">

	<link href="/css/animate.css" rel="stylesheet">
	<link href="/css/style.css" rel="stylesheet">
    <link href="/css/datetimepicker.css" rel="stylesheet">
    <link href="/css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
</head>
<body class="gray-bg">

	@yield('content')

	<!-- Mainly scripts -->
	<script src="/js/jquery-2.1.1.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/moment.min.js"></script>
	<script src="/js/datetimepicker.js"></script>
	<script src="/js/plugins/steps/jquery.steps.min.js"></script>
	@yield('scripts')
</body>
</html>