<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset=UTF-8'>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- CSRF Token -->
	<meta name = "csrf-token" content = "{{ csrf_token() }}">
	<meta name = "urlNext"    content = "{{ route('simSiguiente') }}">
	<meta name = "app-name"   content = "{{ config('app.name') }}">

	<title>{{ config('app.name', 'Simulador') }}</title>

	<!-- Fonts 
	<link rel="dns-prefetch" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">-->

	<!-- Styles 
	<link href="{{ asset('css/argon.css') }}" rel="stylesheet">
	<link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/estilo.css') }}" rel="stylesheet">-->

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

	<!-- Bootstrap Core Css -->
	<link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

	<!-- Waves Effect Css -->
	<link href="{{ asset('plugins/node-waves/waves.css') }}" rel="stylesheet" />

	<!-- Animation Css -->
	<link href="{{ asset('plugins/animate-css/animate.css') }}" rel="stylesheet" />

	<!-- Morris Chart Css-->
	<link href="{{ asset('plugins/morrisjs/morris.css') }}" rel="stylesheet" />

	<!-- Custom Css -->
	<link href="{{ asset('css/adminTemplate/style.css') }}" rel="stylesheet">

	<!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
	<link href="{{ asset('css/adminTemplate/themes/all-themes.css') }}" rel="stylesheet" />
	
	<!-- Sweet Alert 2 css -->
	<link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">

	<!-- Estilo propio -->
	<link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
	
	<!-- JQuery DataTable Css -->
	<link href="{{ asset('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">

	<!-- Bootstrap Select Css -->
	<link href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

	@yield('assets')
	
</head>
<body class="theme-blue">
	@include('simulador.dashboard.preloader')
	 <!-- Overlay For Sidebars -->
	<div class="overlay"></div>
		@include('simulador.dashboard.navbar')
		<section>
			@include('simulador.dashboard.leftSideBar')
			@include('simulador.dashboard.rigthSideBar')
		<!-- #END# Right Sidebar -->
	</section>
	<section class="content">
			@yield('content')
	</section>
	</div>
</body>
</html>



<!-- Scripts 
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery-3.3.1.min.js') }}"></script>-->
<script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
<!-- Jquery Core Js -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap Core Js -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>
<!-- Select Plugin Js -->
<script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
<!-- Slimscroll Plugin Js -->
<script src="{{ asset('plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
<!-- Waves Effect Plugin Js -->
<script src="{{ asset('plugins/node-waves/waves.js') }}"></script>
<!-- Jquery CountTo Plugin Js -->
<script src="{{ asset('plugins/jquery-countto/jquery.countTo.js') }}"></script>
<!-- Morris Plugin Js -->
<script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('plugins/morrisjs/morris.js') }}"></script>
<!-- ChartJs -->
<script src="{{ asset('plugins/chartjs/Chart.bundle.js') }}"></script>
<!-- Flot Charts Plugin Js -->
<script src="{{ asset('plugins/flot-charts/jquery.flot.js') }}"></script>
<script src="{{ asset('plugins/flot-charts/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('plugins/flot-charts/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('plugins/flot-charts/jquery.flot.categories.js') }}"></script>
<script src="{{ asset('plugins/flot-charts/jquery.flot.time.js') }}"></script>
<!-- Sparkline Chart Plugin Js -->
<script src="{{ asset('plugins/jquery-sparkline/jquery.sparkline.js') }}"></script>
<!-- Custom Js -->
<script src="{{ asset('js/adminTemplate/admin.js') }}"></script>
<!-- <script src="{{ asset('js/adminTemplate/pages/index.js') }}"></script>-->
<!-- Demo Js -->
<script src="{{ asset('js/adminTemplate/demo.js') }}"></script>
<script src="{{ asset('js/jquery.mask.js') }}"></script>

@yield('scripts')