@section('content')	
	{{'proyeccionVenta'}}
	<h2 class="align-center col-pink">{{ __('messages.proyecciones') }}<span id="spanYear"></span></h2>
	{{-- Primer Fila de Cards --}}
	<div class="container-fluid">
		<div class="col-lg-3"></div>
		<div class="col-lg-6">
			<div class="card">
				<div class="body">
					<form id="formInteresProd">
						<fieldset>
							{{-- Tasa De Crecimiento En Ventas (tasaCreVen)--}}
							<div class="row">
								<div class="col-md-12"  style="margin-bottom: 0px !important">
									<div class="input-group" style="margin-bottom: 5px !important">
										<span class="input-group-addon">{{ __('messages.tasaCreVen') }}:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										<div class="form-line">
											<input
												type        = "number"
												id          = "txtTasaCreVen"
												class       = "form-control" 
												placeholder = "Ej. 5%"
												min         = "1"
												max         = "100"
												oninput     = "validarInput(this)"
												onkeypress  = "return checaEnter(event, 'proyecciones')"
												value       = "17"
												required
											>
										</div>
									</div>
								</div>
							</div>
							{{-- Tasa De Crecimiento En Población (tasaCrePob) --}}
							<div class="row">
								<div class="col-md-12"  style="margin-bottom: 0px !important">
									<div class="input-group" style="margin-bottom: 5px !important">
										<span class="input-group-addon">{{ __('messages.tasaCrePob') }}:</span>
										<div class="form-line">
											<input
												type        = "number"
												id          = "txtTasaCrePob"
												class       = "form-control"
												placeholder = "Ej. 5%"
												min         = "1"
												max         = "100"
												oninput     = "validarInput(this)"
												onkeypress  = "return checaEnter(event, 'proyecciones')"
												value       = "9"
												requied
											>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="sm-12 align-right" id="divBtnSiguiente">
									<button id="btnProVen"	type="button" class="btn bg-blue waves-effect" onclick="javascript:hacerProyeccion()" disabled>
										<i class="material-icons">verified_user</i>
										<span>{{ __('messages.siguiente') }}</span>
									</button>
									&nbsp;
									&nbsp;
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<div id="divProyAnual" class="row" style="visibility: hidden;">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="body">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="col-pink">{{ __('messages.mercadoAno') }}</th>
									<th><span id="spanYear1" class="col-pink"></span></th>
									<th><span id="spanYear2" class="col-pink"></span></th>
									<th><span id="spanYear3" class="col-pink"></span></th>
									<th><span id="spanYear4" class="col-pink"></span></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="col-cyan"><b>{{ __('messages.mercadoPotencial') }}</b></td>
									<td><span id="spanMercPot1"></span></td>
									<td><span id="spanMercPot2"></span></td>
									<td><span id="spanMercPot3"></span></td>
									<td><span id="spanMercPot4"></span></td>
									<td class="font-bold">{{ __('messages.personas') }}</td>
								</tr>
								<tr>
									<td class="col-cyan"><b>{{ __('messages.mercDisp') }}</b></td>
									<td><span id="spanMercDisp1"></span></td>
									<td><span id="spanMercDisp2"></span></td>
									<td><span id="spanMercDisp3"></span></td>
									<td><span id="spanMercDisp4"></span></td>
									<td class="font-bold">{{ __('messages.personas') }}</td>
								</tr>
								<tr>
									<td class="col-cyan"><b>{{ __('messages.mercEfec') }}</b></td>
									<td><span id="spanMercEfec1"></span></td>
									<td><span id="spanMercEfec2"></span></td>
									<td><span id="spanMercEfec3"></span></td>
									<td><span id="spanMercEfec4"></span></td>
									<td class="font-bold">{{ __('messages.personas') }}</td>
								</tr>
								<tr>
									<td class="col-cyan"><b>{{ __('messages.mercObje') }}</b></td>
									<td><span id="spanMercObje1"></span></td>
									<td><span id="spanMercObje2"></span></td>
									<td><span id="spanMercObje3"></span></td>
									<td><span id="spanMercObje4"></span></td>
									<td class="font-bold">{{ __('messages.personas') }}</td>
								</tr>
								<tr>
									<td class="col-cyan"><b>{{ __('messages.consAnualMerc') }}</b></td>
									<td><span id="spanConsAnu1"></span></td>
									<td><span id="spanConsAnu2"></span></td>
									<td><span id="spanConsAnu3"></span></td>
									<td><span id="spanConsAnu4"></span></td>
									<td class="font-bold">{{ trans_choice('messages.unidad',2) }}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="sm-12 align-right" id="divBtnSiguiente">
						<button	type="button" class="btn bg-blue waves-effect" onclick="javascript:calcVentasAn1()">
							<i class="material-icons">verified_user</i>
							<span>{{ __('messages.calcVentasAn1') }}</span>
						</button>
						&nbsp;
						&nbsp;
					</div>
					<br>
				</div>
			</div>
		</div>
		<div id="divVentasMensuales" class="row" style="visibility: hidden;">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="body">
						<h3 class="col-pink align-center">{{ __('messages.ventasMens') }}</h3>
						<table class="table table-striped">
							<thead>
								<tr>
									<th><span class="col-pink">{{ __('messages.timeZero') }}</span></th>
									<th><span class="col-pink">{{ __('messages.porcentaje') }}</span></th>
									<th><span class="col-pink">{{ trans_choice('messages.unidad',2) }}</span></th>
									<th><span class="col-pink">{{ __('messages.precioVenta') }}</span></th>
									<th><span class="col-pink">{{ __('messages.total') }}</span></th>
									<th><span class="col-pink">???</span></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@for ($i = 1; $i < 13; $i++)
									<tr>
										<td><span class="spanMes" id="spanMes{{ $i }}"></span></td>
										<td>
											<input
												id       = "inputPorcentaje{{ $i }}"
												type     = "number"
												min      = "0"
												max      = "100"
												step     = "1" 
												value    = "8" {{-- Eliminar despues de pruebas --}}
												onInput  = "javascript:sumaVentasMensuales()"
												class    = "classInputPorcentaje"
											>
										</td>
										<td><span class="spanUnidad" id="spanUnidad{{ $i }}"></span></td>
										<td><span class="spanPrecioVenta"></span></td>
										<td><span class="spanTotal" id="spanTotal{{ $i }}"></span></td>
										<td><span id="spanCostoUnitario{{ $i }}"></span></td>
									</tr>
								@endfor
								<tr>
									<td class="align-right">Total: </td>
									<td><span class="claseSuma" id="spanSumaPorcentajes"></span> %</td>
									<td><span class="claseSuma" id="spanSumaUnidades"></span></td>
									<td></td>
									<td>$ <span class="claseSuma" id="spanSumaTotal"></span></td>
									<td>$ <span class="claseSuma" id="spanSumaCostoUni"></span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection