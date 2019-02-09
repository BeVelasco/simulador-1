    <script>
		{{-- Javascript Global Routes --}}
		var routes = {
                guradarInventario   : "{{ route('guardarInventario') }}",
                getData             : "{{ route('getDataSimulador') }}",
                calcularPrecioVenta : "{{ route('calcularPrecioVenta') }}", {{-- -SimuladorController@calcularPrecioVenta --}}
                regionObjetivo      : "{{ route('regionObjetivo') }}",
                getSegmentacion     : "{{ route('getSegmentacion') }}", {{-- PronosticoVentasController@getSegmentacion --}}
                getVista            : "{{ route('getVista') }}",
                getProyeccion       : "{{ route('getProyeccion') }}",
                getMeses            : "{{ route('getMeses') }}",
                home                : "{{ route('home') }}",
                guardarMercadotecnia: "{{ route('guardarMercadotecnia') }}",
                inicioSimulador     : "{{ route('inicioSimulador') }}",
        };
	</script>
    {{-- Jquery Core Js --}}
    <script src="{{ asset('plugins/jquery/jquery-2.2.4.min.js') }}"></script>
	{{-- timeline --}}
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    {{-- Bootstrap Core Js --}}
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>
    {{-- Select Plugin Js --}}
    <script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
    {{-- Slimscroll Plugin Js --}}
    <script src="{{ asset('plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
    {{-- Waves Effect Plugin Js --}}
    <script src="{{ asset('plugins/node-waves/waves.js')}}"></script>
    {{-- ChartJs --}}
    <script src="{{ asset('plugins/chartjs/Chart.js') }}"></script>
    <script src="{{ asset('plugins/chartjs/Chart.bundle.js') }}"></script>
    {{-- Flot Charts Plugin Js --}}
    <script src="{{ asset('plugins/flot-charts/jquery.flot.js') }}"></script>
    <script src="{{ asset('plugins/flot-charts/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('plugins/flot-charts/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('plugins/flot-charts/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('plugins/flot-charts/jquery.flot.time.js') }}"></script>
    {{-- Sparkline Chart Plugin Js --}}
    <script src="{{ asset('plugins/jquery-sparkline/jquery.sparkline.js') }}"></script>
	{{-- RangeSlider Plugin Js --}}
    <script src="{{ asset('plugins/ion-rangeslider/js/ion.rangeSlider.js')}}"></script>
	{{-- easypiechart Plugin Js --}}
	{{--<script src="../../plugins/chartjs/jquery.easypiechart.js"></script>--}}
	<script src="{{ asset('plugins/chartjs/createWaterBall-jquery.js')}}"></script>
	{{-- Menu--}}
	<script src="{{ asset('plugins/menu-hc-offcanvas-nav/hc-offcanvas-nav.js?ver=3.4.0')}}"></script>
    {{-- block --}}
    <script src="{{ asset('plugins/jquery-blockUI/jquery.blockUI.js')}}"></script>
    {{-- sweet alert --}}
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    {{-- Custom Js --}}
    <script src="{{ asset('js/admin.js')}}"></script>
    {{-- Scrip con las funciones globales --}}
    <script src="{{ asset('js/funcionesGlobales.js') }}"></script>  