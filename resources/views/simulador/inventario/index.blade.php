@extends('simulador.base')

@section('content')

<div class="card" id="baseInventario">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="header bg-green">
				<h2>
					{{ trans_choice('messages.inventario', 2) }}
					<small>
						{{ Session::get('prodSeleccionado') -> idesc }} para: {{ Session::get('prodSeleccionado') -> porcionpersona }} {{ Session::get('prodSeleccionado') -> catum -> idesc }}
					</small>
				</h2>
			</div>
			<div class="body">
				<div class="row">
					<h2 class="align-center col-pink">{{ __('messages.politicaInventario') }}</h2>
					<h4 class="align-center col-blue">{{ __('messages.descPoliticaInv') }}</h4>
					<div class="col-lg-2 col-md-2"></div>
					<div class="col-lg-8 col-md-8">
						<div class="card">
							<div class="body" style="padding-bottom: 0px !important;">
								<div class="form-horizontal" id="formInventario">
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
											<p class="text-right">{{ __('messages.ventasAnuales') }}:</p>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
											<p class="text-left"><span id=spanUniVenAnu>{{ Session::get('pronostico.totalUnidades') }}</span> {{ trans_choice('messages.unidad',2) }} </p>
										</div>
									</div>
									<div class="row clearfix">
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
											<p class="text-right">{{ __('messages.ventasPromMensual') }}:</p>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
											<p class="text-left"><span id="spanVenProMen">{{ (Session::get('pronostico.totalUnidades'))/12 }}</span>	</p>
										</div>
									</div>
									<div class="row clearfix">
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
											<p class="text-right">{{ __('messages.porcInvDeseado') }}:</p>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
											<input
												type      = "number"
												id        = "txtPorFinDes"
												class     = "form-control"
												type      = "number"
												min       = "0.00"
												max       = "100.00"
												step      = "1"
												onkeydown = "return eliminaEInput(event)"
												oninput   = "calcularInventario(this)"
												required
												autofocus
											>
										</div>
									</div>
									<div class="row clearfix">
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
											<p class="text-right">{{ __('messages.uniDesInvFin') }}:</p>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
											<p><span id="spanUniDesInvFin">0.00</span></p>
										</div>
										
									</div>
									
									<hr style="margin-top: 0px !important;">
									<div class="row clearfix">
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
											<p class="text-right">{{ __('messages.costoDirecto') }}:</p>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
											<p>$ <span id="spanCostoDirecto">{{ Session::get('costoUnitario') }}</span></p>
										</div>
										
									</div>
									<div class="row clearfix">
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
											<p class="text-right">{{ __('messages.valInvFinDes') }}:</p>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
											<p>$ <span id="spanValInvFinDes">0.00</span></p>
										</div>
									</div>
									<div class="row clearfix">
										<div class="col-lg-offset-10 col-md-offset-10 col-sm-offset-10 col-xs-offset-6">
											<button type="button" class="btn btn-primary m-t-15 waves-effect" onclick="return guardarInventario()">{{ __('messages.guardar') }}</button>
										</div>
									</div>
									<br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			inventario.index
		</div>
	</div>

@endsection

@section('scripts')
	<script src="{{ asset('js/simuladorScriptsInventario.js') }}"></script>
@endsection