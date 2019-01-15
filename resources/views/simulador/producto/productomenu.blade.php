@extends('base')

@section('content')
<div class="container-fluid">
	<div class="row clearfix">
		<!-- Task Info -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card" id="divPrueba">
				<div class="header">
					<h2 style="text-transform: uppercase;">{{ trans_choice('messages.productos', 2) }}</h2><!-- messages.productos -->
				</div>
				<div class="body">
					<div class="table-responsive">
						<table class="table table-hover dashboard-task-infos">
							<thead>
								<tr>
									
									<th>{{ __('messages.descripcion') }}</th><!-- messages.descripcion -->
									<th>{{ __('messages.porcion') }}</th><!-- messages.porcion -->
									<th>{{ __('messages.status') }}</th><!-- messages.status -->
									<th>{{ __('messages.acciones') }}</th>
								</tr>
							</thead>
							<tbody id="tablaProd">
								@foreach($productos as $producto)
									<tr>
										<td>{{ $producto -> idesc }}</td>
										<td>{{ $producto -> porcionpersona}} - {{ $producto -> descum }}</td>
										<td>
										  <span class="label bg-{{$producto -> colorstate}}">{{ __('messages.'.$producto -> state) }}</span><!-- messages.activo -->
										</td>
										
										<td>
										<a href="javascript:editarProducto('{{ $producto->id }}');">
												<button type="button" class="btn bg-black waves-effect waves-light">
													{{ __('messages.producto_editarboton') }}
												</button>
											</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						
					</div>
				</div>
			</div>
		</div>
		<!-- #END# Task Info -->
@endsection

@section('scripts')
	@include('simulador.dashboard.jsDataTable')
	<script src="{{ asset('js/productomenuScripts.js') }}"></script>
	<script src="{{ asset('js/adminTemplate/pages/ui/tooltips-popovers.js') }}"></script>
	@if ($noProductos == 0)
		<script>mostrarAlerta('error','{{ config('app.name') }}','{{ __('messages.sinProductos') }}', 'messages.sinProductos' )</script>
		<!-- messages.sinProductos -->
	@endif
@endsection