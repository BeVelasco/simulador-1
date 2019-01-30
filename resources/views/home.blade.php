@extends('base')
@section('assets')
    <style>
        .card .header h2{
            width:50%;
        }
    </style>
@endsection
@section('content')

<div class="container-fluid">
	@include('simulador.dashboard.widgets')
	<div class="row clearfix">
		<!-- Task Info -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card" id="divPrueba">
				<div class="header" style="padding-bottom: 0px;">
					<h2 style="text-transform: uppercase;" id="tituloProyecto">{{ trans_choice('messages.productos', 2).' de: '. $proyecto }}</h2><!-- messages.productos -->
    	               <div class="sm-8 align-right">
							<ul class="toolbar-form" style="top: -20px;position: relative;">
                                <li>
									<button class="btn bg-blue waves-effect"	
                                        type          = "button"
										data-toggle   = "modal"
										data-target   = "#addProyecto"
										data-backdrop = "static"
										data-keyboard = "false"
									>
										{{ __('messages.nombrarProyecto')}} 
									</button>
								</li>
								<li>
									<button class="btn bg-blue waves-effect"	
										id            = "paso1Guia"
                                        type          = "button"
										data-toggle   = "modal"
										data-target   = "#addProduct"
										data-backdrop = "static"
										data-keyboard = "false"
										onclick       = "javascript:quitarPopover('#paso1Guia')"
									>
										{{ __('messages.agregarProducto')}} <!-- messages.agregarProducto -->
									</button>
								</li>
								<li>
									<button class="btn bg-blue waves-effect"
										type          = "button"
										data-toggle   = "modal"
										data-target   = "#addUnidaMedida"
										data-backdrop = "static"
										data-keyboard = "false""
									>
										{{ __('messages.agregarUM')}}<!-- messages.agregarUM -->
									</button>
								</li>
							</ul>
                        </div>
				</div>
				<div class="body">
                    <div class="col-sm-8 align-right"></div>
    				<div class="col-sm-2 "><b>Información general</b></div>
                    <div class="col-sm-2 ">
                        <div class="dropdown">
                            <a href="#" data-toggle="dropdown" class="btn bg-black waves-effect waves-light dropdown-toggle">Ir a ...<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:linkmenu('{{ 0 }}','/iniciarSimulador','/nomina/editarInicio');">{{ __('messages.nomina_boton') }}</a></li>
                                <li><a href="javascript:linkmenu('{{ 0 }}','/iniciarSimulador','/inicial/editarInicio');">{{ __('messages.inversion_inicialboton') }}</a></li>
                                <li><a href="javascript:linkmenu('{{ 0 }}','/iniciarSimulador','/reportes/perdidasganancias');">{{ __('messages.perdidas_gananciasboton') }}</a></li>
                                
                            </ul>
                        </div>
                    </div>
                    <div class="row clearfix">
                    </div>
					<div class="table-responsive" style="height: 10000px;">
						<table class="table table-hover dashboard-task-infos">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ __('messages.descripcion') }}</th>
									<th>{{ __('messages.porcion') }}</th>
									<th>{{ __('messages.status') }}</th>
									<th>{{ __('messages.creado') }}</th>
									<th>{{ __('messages.acciones') }}</th>
								</tr>
							</thead>
							<tbody id="tablaProd">
								@foreach($productos as $producto)
									<tr>
										<td>{{ $loop -> iteration + (($productos -> currentPage()-1) * 10) }}</td>
										<td>{{ $producto -> idesc }}</td>
										<td>{{ $producto -> porcionpersona}} - {{ $unidadMedidas[$producto -> idcatnum1 - 1 ] ->idesc }}</td>
										<td>
											@if ($producto -> state == 'A')
												<span class="label bg-green">{{ __('messages.activo') }}</span><!-- messages.activo -->
											@endif
										</td>
										<td> {{$producto -> created_at -> diffForHumans()}}</td>
										<td>
                                            <div class="dropdown">
                                                <a href="#" data-toggle="dropdown" class="btn bg-black waves-effect waves-light dropdown-toggle">Ir a ...<b class="caret"></b></a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="javascript:linkmenu('{{ $producto->id }}','/iniciarSimulador','/simulador/inicio');">{{ __('messages.iniSimulador') }}</a></li>
                                                    <li><a href="javascript:linkmenu('{{ $producto->id }}','/iniciarSimulador','/producto/editarInicio');">{{ __('messages.productoproduccion_boton') }}</a></li>
                                                    <li><a href="javascript:linkmenu('{{ $producto->id }}','/iniciarSimulador','/tkt/editarInicio');">{{ __('messages.tkt_boton') }}</a></li>
                                                </ul>
                                            </div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<br><br><br><br><br><br>
						{{ $productos->links() }}
					</div>
				</div>
			</div>
		</div>
		<!-- #END# Task Info -->
@include('simulador.modals.addProyecto')        
@include('simulador.modals.addProduct')
@include('simulador.modals.addUnidadMedida')
@endsection

@section('scripts')
	@include('simulador.dashboard.jsDataTable')
	<script src="{{ asset('js/dashboardScripts.js') }}"></script>
	<script src="{{ asset('js/adminTemplate/pages/ui/tooltips-popovers.js') }}"></script>
	@if ($noProductos == 0)
		<script>mostrarAlertaPopUp('error','{{ config('app.name') }}','{{ __('messages.sinProductos') }}', 'messages.sinProductos' )</script>
		<!-- messages.sinProductos -->
	@endif
@endsection