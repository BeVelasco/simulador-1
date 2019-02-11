@extends('base')

@section('assets')
	<link href="{{ asset('css/jExcel/jquery.jcalendar.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jdropdown.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.green.css') }}" rel="stylesheet">

    <style>
        .jexcel > thead > tr, .jexcel > tbody > tr {
            display: table-row
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
	<br>
	<div class="card">
		<div class="header bg-pink">
			<h2>
				@php $idProducto = Session::get('prodSeleccionado'); @endphp
				{{ producto($idProducto, 'idesc') }}
				<small>
					Para: {{ producto($idProducto,'porcionpersona') }} {{ catum(producto($idProducto,'idcatnum1'), 'idesc') }}
				</small>
			</h2>
		</div>
		<div class="body">
            <div class="row">
				<div class="sm-8 align-right">
                    <ul class="toolbar-form">
           				<li>
        					<button type="button" class="btn bg-blue waves-effect" onclick="javascript:regresar();">
        						<i class="material-icons">arrow_back</i>
        						<span>{{ __('messages.regresar') }}</span>
        					</button>
        				</li>
        			</ul>
				</div>
			</div>
            <div class="row">
                &nbsp;
            </div>
			<div id="mytable"></div>
			<div class="row">
				<br><br>
				<div class="col-sm-12">
					<form id="formPrecioVenta">
						<fieldset>
							<div class="row clearfix">
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
									<label>{{ __('messages.porcentajeBBD') }}</label><!-- messages.porcentajeBBD -->
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
									<div class="form-group">
										<div class="form-line">
											<input id="PBBD" name="PBBD" type="number" max="99" step="0.01" value="{{ Session::get('PBBD') }}" min="0.01" required class="form-control">
										</div>
									</div>
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
									<button type="button" class="btn btn-primary btn-lg m-l-15 waves-effect" onclick="javascript:calcularPrecioVenta()">Calcular</button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8" id="divResultados2" @if ( Session::get('datosCalculados') == false ) hidden @endif>
					<div class="card" id="cardGraf">
						<div class="header">
							<h2>{{ __('messages.precioVenta') }} = 100%</h2>
						</div>
						<div class="body" style="text-align: center !important;">
							<center><div id="divGrafica" style="width:50%; height:50%"></div></center>
						</div>
					</div>
				</div>
				<div class="col-sm-4" id="divResultados" @if ( Session::get('datosCalculados') == false ) hidden @endif>
					<div class="card">
						<div class="header">
							<h2 class="">{{ __('messages.detPrecVentProd') }} </h2>
						</div>
						<div class="body table-responsive">
							<table class="table" style="padding: 5px !important;">
								<tbody>
									<tr class="bg-pink">
										<th class="align-right">
											{{ __('messages.sumaCP') }}:
										</th>
										<td>
											$ <span id="sumCI">@if ( !Session::get('sumCI') == null ) {{ Session::get('sumCI') }}@endif</span>
										</td>
									</tr>
									<tr class="bg-teal">
										<th class="align-right">
											{{ __('messages.recetaPara') }}:
										</th>
										<td>
											<span id="recetaPara">
												{{ producto($idProducto,'porcionpersona') }} {{ catum(producto($idProducto,'idcatnum1'), 'idesc') }}
											</span>
										</td>
									</tr>
									<tr class="bg-purple">
										<th class="align-right">
											{{ __('messages.costoUnitario') }}:
										</th>
										<td>
											$ <span id="costounitario">
												{{ Session::get('costoUnitario') }}
											</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="body table-responsive">
							<table class="table" style="padding: 5px !important;">
								<tbody>
									<tr class="bg-pink">
										<th class="align-right">
											{{ __('messages.costoPV') }}:
										</th>
										<td>
											$ <span id="costoUni">
												@if ( !Session::get('costoUnitario') == null ) {{ Session::get('costoUnitario') }}@endif
											</span>
										</td>
									</tr>
									<tr class="success">
										<th class="align-right">
											{{ __('messages.precioVenta') }}:
										</th>
										<td>
											$ <span id="precioVen">
												@if ( !Session::get('precioVenta') == null ) {{ Session::get('precioVenta') }}@endif
											</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="sm-12 align-right" @if ( Session::get('datosCalculados') == false ) hidden @endif id="divBtnSiguiente">
					<button type="button" class="btn bg-blue waves-effect" onclick="javascript:siguiente(2)">
						<i class="material-icons">verified_user</i>
						<span>{{ __('messages.siguiente') }}</span>
					</button>
					&nbsp;
					&nbsp;
				</div>
			</div>
		</div>
	</div>
	simulador.inicio
</div>
@endsection

@section('scripts')
	<script src="{{ asset('js/jExcel/jquery.jexcel.js') }}"></script>
	<script src="{{ asset('js/jExcel/excel-formula.min.js') }}"></script>
	<script src="{{ asset('js/jExcel/jquery.csv.min.js') }}"></script>
	<script src="{{ asset('js/jExcel/jquery.jcalendar.js') }}"></script>
	<script src="{{ asset('js/jExcel/jquery.jdropdown.js') }}"></script>
	<script src="{{ asset('js/jExcel/numeral.min.js') }}"></script>
	<script src="{{ asset('js/simuladorScripts.js') }}"></script>
@endsection
