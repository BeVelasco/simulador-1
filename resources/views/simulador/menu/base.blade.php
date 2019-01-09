<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
	<meta name = "csrf-token" content = "{{ csrf_token() }}">
	<meta name = "urlNext"    content = "{{ route('simSiguiente') }}">
	<meta name = "app-name"   content = "{{ config('app.name') }}">

    <title>{{ config('app.name', 'Simulador') }}</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <!--<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:200,300,400,600,700">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('plugins/animate-css/animate.css') }}" rel="stylesheet" />
	
	<!-- Range Slider Css -->
    <link href="{{ asset('plugins/ion-rangeslider/css/ion.rangeSlider.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/ion-rangeslider/css/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet" />
	
	<!-- Menu Css -->
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	
    <!-- Custom Css -->
    <link href="{{ asset('plugins/menu-hc-offcanvas-nav/hc-offcanvas-nav.css') }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('css/themes/all-themes.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet">

	@yield('assets')
	
</head>
<body class="theme-red">
	@include('simulador.dashboard.preloader')
	 <!-- Overlay For Sidebars -->
	<div class="overlay"></div>
		@include('simulador.dashboard.searchBar')
		@include('simulador.dashboard.navbar')
		<section>
			@include('simulador.menu.leftSideBar')
		</section>
	<section class="content">
			@yield('content')
	</section>
	</div>
</body>
</html>

<!-- Jquery Core Js -->
    <script src="{{ asset('plugins/jquery/jquery-2.2.4.min.js') }}"></script>
	
	<!-- timeline -->
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Select Plugin Js -->
    <script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('plugins/node-waves/waves.js')}}"></script>

	<!-- RangeSlider Plugin Js -->
    <script src="{{ asset('plugins/ion-rangeslider/js/ion.rangeSlider.js')}}"></script>
	
	<!-- easypiechart Plugin Js -->
	<!--<script src="../../plugins/chartjs/jquery.easypiechart.js"></script>-->
	<script src="{{ asset('plugins/chartjs/createWaterBall-jquery.js')}}"></script>
	
	<!-- Menu-->
	<script src="{{ asset('plugins/menu-hc-offcanvas-nav/hc-offcanvas-nav.js?ver=3.4.0')}}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('js/admin.js')}}"></script>

    <!-- Demo Js -->
    <script src="{{ asset('js/demo.js')}}"></script>
    <script src="{{ asset('js/menuScript.js') }}"></script>
