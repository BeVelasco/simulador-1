@extends('base')

@section('content')
<br>
<div class="container-fluid">
	@include('simulador.dashboard.widgets')
	<div class="row clearfix">
		<!-- Task Info -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card" id="divPrueba">
				<div class="header">
					<h2 style="text-transform: uppercase;">{{ trans_choice('messages.productos', 2) }}</h2><!-- messages.productos -->
					<ul class="header-dropdown m-r--5">
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="material-icons" id="paso1Guia" onclick="javascript:quitarPopover('#paso1Guia');">more_vert</i>
							</a>
							<ul class="dropdown-menu pull-right">
								<li>
									<a 	
										data-toggle   = "modal"
										data-target   = "#addProduct"
										data-backdrop = "static"
										data-keyboard = "false"
									>
										{{ __('messages.agregarProducto')}} <!-- messages.agregarProducto -->
									</a>
								</li>
								<li>
									<a 
										type          = "button"
										data-toggle   = "modal"
										data-target   = "#addUnidaMedida"
										data-backdrop = "static"
										data-keyboard = "false""
									>
										{{ __('messages.agregarUM')}}<!-- messages.agregarUM -->
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="body">
					<div class="table-responsive">
						<table class="table table-hover dashboard-task-infos">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ __('messages.descripcion') }}</th><!-- messages.descripcion -->
									<th>{{ __('messages.porcion') }}</th><!-- messages.porcion -->
									<th>{{ __('messages.status') }}</th><!-- messages.status -->
									<th>{{ __('messages.creado') }}</th><!-- messages.creado -->
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
										<a href="javascript:comenzarSimulador('{{ $producto->id }}');">
												<button type="button" class="btn bg-black waves-effect waves-light">
													{{ __('messages.iniSimulador') }}
												</button>
											</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						{{ $productos->links() }}
					</div>
				</div>
			</div>
		</div>
		<!-- #END# Task Info -->
@include('simulador.modals.addProduct')
@include('simulador.modals.addUnidadMedida')
@endsection

@section('scripts')
	@include('simulador.dashboard.jsDataTable')
	<script src="{{ asset('js/dashboardScripts.js') }}"></script>
	<script src="{{ asset('js/adminTemplate/pages/ui/tooltips-popovers.js') }}"></script>
	@if ($noProductos == 0)
		<script>mostrarAlerta('error','{{ config('app.name') }}','{{ __('messages.sinProductos') }}', 'messages.sinProductos' )</script>
		<!-- messages.sinProductos -->
	@endif
@endsection