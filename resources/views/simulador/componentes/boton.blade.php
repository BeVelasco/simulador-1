@section('content')
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn bg-black waves-effect waves-light dropdown-toggle" aria-expanded="true">Ir a ...<b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li><a href="javascript:linkmenu('%id%','{{ route('iniciarSimulador') }}','{{ route('inicioSimulador') }}');">{{ __('messages.iniSimulador') }}</a></li>
        <li><a href="javascript:linkmenu('%id%','{{ route('iniciarSimulador') }}','{{ route('editarInicioProducto') }}');">{{ __('messages.productoproduccion_boton') }}</a></li>
        <li><a href="javascript:linkmenu('%id%','{{ route('iniciarSimulador') }}','{{ route('editarInicioTkt') }}');">{{ __('messages.tkt_boton') }}</a></li>
    </ul>
</div>
@endsection