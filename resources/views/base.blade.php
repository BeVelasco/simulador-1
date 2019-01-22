<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('simulador.componentes.head')
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
        @if(Session::has('error')) @include('simulador.dashboard.alertas.error') @endif
        @yield('content')
	</section>
	</div>
</body>
</html>
@include('simulador.componentes.js')
@yield('scripts')