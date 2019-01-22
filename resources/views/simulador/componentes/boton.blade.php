@section('content')
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn bg-black waves-effect waves-light dropdown-toggle" aria-expanded="true">Ir a ...<b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li><a href="javascript:linkmenu('%id%','/iniciarSimulador','/simulador/inicio');" class=" waves-effect waves-block">Comenzar simulador</a></li>
        <li><a href="javascript:linkmenu('%id%','/iniciarSimulador','/tkt/editarInicio');" class=" waves-effect waves-block">Takt time</a></li>
        <li><a href="javascript:linkmenu('%id%','/iniciarSimulador','/nomina/editarInicio');" class=" waves-effect waves-block">Nómina</a></li>
        <li><a href="javascript:linkmenu('%id%','/iniciarSimulador','/acumulado/editarInicio');" class=" waves-effect waves-block">Acumulado inicial</a></li>
    </ul>
</div>
@endsection