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
		<link href="/css/summernote.css" rel="stylesheet">
	<link href="/css/summernote-bs3.css" rel="stylesheet">
		<link href="/css/custom.css" rel="stylesheet">
	</head>
	<body class="top-navigation pace-done"><div class="pace  pace-inactive"><div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
		<div class="pace-progress-inner"></div>
	</div>
	<div class="pace-activity"></div></div>
	<div id="wrapper">
		<div id="page-wrapper" class="gray-bg">
			<div class="row border-bottom white-bg">
				<div class="container">
					<div class="row">
						<nav class="navbar navbar-static-top" role="navigation">
							<div class="navbar-header">
								<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
								<i class="fa fa-reorder"></i>
								</button>
								<a href="#" class="navbar-brand">PSD</a>
							</div>
							<div class="navbar-collapse collapse" id="navbar">
								<ul class="nav navbar-nav">
									<li class="{{ Request::is('services') ? 'active' : '' }}">
										<a aria-expanded="false" role="button" href="/services"> Services List</a>
									</li>
								</ul>
								<ul class="nav navbar-top-links navbar-right">
									<li>
										<a href="/email-logout">
											<i class="fa fa-sign-out"></i> Log out
										</a>
									</li>
								</ul>
							</div>
						</nav>
					</div>
				</div>
			</div>
			<div class="wrapper wrapper-content">
				@yield('content')
			</div>
			<div class="footer">
				<div class="text-center">
					<strong>Copyright</strong> Company © {{ Date('Y') }}
				</div>
			</div>
		</div>
	</div>
	<!-- Mainly scripts -->
	<script src="/js/jquery-3.1.1.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/common.js"></script>
	<script src="/js/bootbox.min.js"></script>
	<script src="/js/summernote.min.js"></script>
</body>
</html>