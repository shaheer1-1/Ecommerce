<!DOCTYPE html>
<html lang="zxx">
<head>
	<!-- Meta Tag -->
@yield('meta')
<!-- Title Tag  -->
<title>@yield('title')</title>
<!-- Favicon -->
<link rel="icon" type="image/png" href="images/favicon.png">
<!-- Web Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

<!-- StyleSheet -->
<link rel="manifest" href="/manifest.json">
<!-- Bootstrap -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.css')}}">
<!-- Magnific Popup -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.min.css')}}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/font-awesome.css')}}">
<!-- Fancybox -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery.fancybox.min.css')}}">
<!-- Themify Icons -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/themify-icons.css')}}">
<!-- Nice Select CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/niceselect.css')}}">
<!-- Animate CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.css')}}">
<!-- Flex Slider CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/flex-slider.min.css')}}">
<!-- Owl Carousel -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/owl-carousel.css')}}">
<!-- Slicknav -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/slicknav.min.css')}}">
<!-- Jquery Ui -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery-ui.css')}}">

<link rel="stylesheet" href="{{ asset('frontend/assets/css/reset.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css')}}">
<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script>
<style>
    /* Multilevel dropdown */
    .dropdown-submenu {
    position: relative;
    }

    .dropdown-submenu>a:after {
    content: "\f0da";
    float: right;
    border: none;
    font-family: 'FontAwesome';
    }

    .dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: 0px;
    margin-left: 0px;
    }

  
</style>
@yield('pageSpecificCSS')

</head>
<body class="js">
	
	<div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
	
	@include('frontend.layouts.header')
	@if(session('success'))
    <div class="alert alert-success alert-dismissable fade show text-center">
        <button class="close" data-dismiss="alert" aria-label="Close">×</button>
        {{session('success')}}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissable fade show text-center">
        <button class="close" data-dismiss="alert" aria-label="Close">×</button>
        {{session('error')}}
    </div>
@endif
	@yield('main-content')
	
	
    <script src="{{ asset('frontend/assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/jquery-migrate-3.0.0.js')}}"></script>
	<script src="{{ asset('frontend/assets/js/jquery-ui.min.js')}}"></script>
	<!-- Popper JS -->
	<script src="{{ asset('frontend/assets/js/popper.min.js')}}"></script>
	<!-- Bootstrap JS -->
	<script src="{{ asset('frontend/assets/js/bootstrap.min.js')}}"></script>
	<!-- Color JS -->
	<script src="{{ asset('frontend/assets/js/colors.js')}}"></script>
	<!-- Slicknav JS -->
	<script src="{{ asset('frontend/assets/js/slicknav.min.js')}}"></script>
	<!-- Owl Carousel JS -->
	<script src="{{ asset('frontend/assets/js/owl-carousel.js')}}"></script>
	<!-- Magnific Popup JS -->
	<script src="{{ asset('frontend/assets/js/magnific-popup.js')}}"></script>
	<!-- Waypoints JS -->
	<script src="{{ asset('frontend/assets/js/waypoints.min.js')}}"></script>
	<!-- Countdown JS -->
	<script src="{{ asset('frontend/assets/js/finalcountdown.min.js')}}"></script>
	<!-- Nice Select JS -->
	<script src="{{ asset('frontend/assets/js/nicesellect.js')}}"></script>
	<!-- Flex Slider JS -->
	<script src="{{ asset('frontend/assets/js/flex-slider.js')}}"></script>
	<!-- ScrollUp JS -->
	<script src="{{ asset('frontend/assets/js/scrollup.js')}}"></script>
	<!-- Onepage Nav JS -->
	<script src="{{ asset('frontend/assets/js/onepage-nav.min.js')}}"></script>
	{{-- Isotope --}}
	<script src="{{ asset('frontend/assets/js/isotope/isotope.pkgd.min.js')}}"></script>
	<!-- Easing JS -->
	<script src="{{ asset('frontend/assets/js/easing.js')}}"></script>

	<!-- Active JS -->
	<script src="{{ asset('frontend/assets/js/active.js')}}"></script>

	
    @yield('pageSpecificJS')

	<script>
		setTimeout(function(){
		  $('.alert').slideUp();
		},5000);
		$(function() {
		// ------------------------------------------------------- //
		// Multi Level dropdowns
		// ------------------------------------------------------ //
			$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
				event.preventDefault();
				event.stopPropagation();

				$(this).siblings().toggleClass("show");


				if (!$(this).next().hasClass('show')) {
				$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
				$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
				$('.dropdown-submenu .show').removeClass("show");
				});

			});
		});
	  </script>

</body>
</html>