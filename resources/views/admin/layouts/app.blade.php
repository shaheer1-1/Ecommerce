<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="@yield('meta_description', 'Noa – Bootstrap 5 Admin & Dashboard Template')">
	<meta name="author" content="Spruko Technologies Private Limited">
	<meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/assets/images/brand/favicon.ico') }}"/>

	<title>@yield('title', 'Admin') — Noa</title>

	<link id="style" href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/css/skin-modes.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet" />

	@yield('pageSpecificCSS')
</head>

<body class="ltr app sidebar-mini">

	<div id="global-loader">
		<img src="{{ asset('admin/assets/images/loader.svg') }}" class="loader-img" alt="Loader">
	</div>

	<div class="page">
		<div class="page-main">

			@include('admin.layouts.header')
			@include('admin.layouts.sidebar')

			<div class="app-content main-content mt-0">
				<div class="side-app">
					@yield('content')
				</div>
			</div>
		</div>
		@include('admin.layouts.footer')
	</div>

	<a href="#top" id="back-to-top"><i class="fa fa-long-arrow-up"></i></a>

	<script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/sidemenu/sidemenu.js') }}"></script>
	<script src="{{ asset('admin/assets/js/apexcharts.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/select2/select2.full.min.js') }}"></script>
	<script src="{{ asset('admin/assets/js/circle-progress.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('admin/assets/js/reply.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/p-scroll/perfect-scrollbar.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/p-scroll/pscroll.js') }}"></script>
	<script src="{{ asset('admin/assets/js/sticky.js') }}"></script>
	<script src="{{ asset('admin/assets/js/themeColors.js') }}"></script>
	<script src="{{ asset('admin/assets/js/custom.js') }}"></script>

	@yield('pageSpecificJS')
</body>

</html>
