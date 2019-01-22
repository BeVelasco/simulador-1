<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
{{-- CSRF Token --}}
<meta name = "csrf-token" content = "{{ csrf_token() }}">
<meta name = "urlNext"    content = "{{ route('simSiguiente') }}">
<meta name = "app-name"   content = "{{ config('app.name') }}">
<title>{{ config('app.name', 'Simulador') }}</title>
{{-- Favicon--}}
<link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
{{-- Google Fonts --}}
{{--<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">--}}
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:200,300,400,600,700">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
{{--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">--}}
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
{{-- Bootstrap Core Css --}}
<link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
{{-- Bootstrap select --}}
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.min.css') }}"/>
{{-- Waves Effect Css --}}
<link href="{{ asset('plugins/node-waves/waves.css') }}" rel="stylesheet" />
{{-- Animation Css --}}
<link href="{{ asset('plugins/animate-css/animate.css') }}" rel="stylesheet" />
{{-- Range Slider Css --}}
<link href="{{ asset('plugins/ion-rangeslider/css/ion.rangeSlider.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/ion-rangeslider/css/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet" />
{{-- sweet alert --}}
<link href="{{ asset('plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />
{{-- Menu Css --}}
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
{{-- Custom Css --}}
<link href="{{ asset('plugins/menu-hc-offcanvas-nav/hc-offcanvas-nav.css') }}" rel="stylesheet">
{{-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes --}}
<link href="{{ asset('css/themes/all-themes.css') }}" rel="stylesheet" />
<link href="{{ asset('css/menu.css') }}" rel="stylesheet">