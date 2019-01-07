@section('content')
{{'mercadoDisponible'}}
<h2 class="align-center col-pink">{{ __('messages.mercados') }}</h2>
	{{-- Primer Fila de Cards --}}
	<div class="row">
		{{-- Interes En Usar El Producto --}}
		<div class="col-lg-6">
			<div class="card">
				<div class="body">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6" style="margin-bottom: 0px !important">
							<br>
							<div class="form-group form-float" style="margin-bottom: 5px !important">
								<div class="form-line">
									<small><label>{{ __('messages.interesProd') }} (%)</label><p>&nbsp;</p></small>
									<input 
										type        = "number"
										id          = "txtIntProd"
										min         = "0.00"
										max         = "100"
										step        = "1"
										class       = "form-control"
										placeholder = "Ej. 30%"
										value       = 0
										oninput     = "calculaMercDisp(this)"
									>
								</div>
							</div>
						</div>
						{{-- Mercado Disponible --}}
						<div class="col-lg-6 col-md-6 col-sm-6 align-center" style="margin-bottom: 0px !important">
							<h4 class=col-cyan>{{ __('messages.mercDisp') }}</h4>
								<h4 class="align-center"><span id="labelMercDisp">0 </span>{{ __('messages.personas') }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		{{-- Capacidad Para Usar Y Comprar EL Producto --}}
		<div id="divCapComProd" class="col-lg-6" style="visibility: hidden;">
			<div class="card">
				<div class="body">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6" style="margin-bottom: 0px !important">
							<br>
							<div class="form-group form-float" style="margin-bottom: 5px !important">
								<div class="form-line">
									<small><label>{{ __('messages.CapComProd') }} (%)</label></small>
									<input 
										type        = "number"
										id          = "txtCapComProd"
										min         = "0.00"
										max         = "100"
										step        = "1"
										class       = "form-control"
										placeholder = "Ej. 30%"
										value       = 0
										oninput     = "calculaCapComProd(this)"
									>
								</div>
							</div>
						</div>
						{{-- Mercado Efectivo --}}
						<div class="col-lg-6 col-md-6 col-sm-6 align-center" style="margin-bottom: 0px !important">
							<h4 class=col-cyan>{{ __('messages.mercEfec') }}</h4>
								<h4 class="align-center"><span id="labelCapComProd">0 </span>{{ __('messages.personas') }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- Segunda Fila de Cards --}}
	<div class="row">
		{{-- Capacicad De Abarcar El Mercado Efectivo --}}
		<div id="divCapAbaMerc" class="col-lg-6" style="visibility: hidden;">
			<div class="card">
				<div class="body">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6" style="margin-bottom: 0px !important">
							<br>
							<div class="form-group form-float" style="margin-bottom: 5px !important">
								<div class="form-line">
									<small><label>{{ __('messages.CapAbaMerc') }} (%)</label></small>
									<input 
										type        = "number"
										id          = "txtCapAbaMerc"
										min         = "0.00"
										max         = "100"
										step        = "1"
										class       = "form-control"
										placeholder = "Ej. 30%"
										value       = 0
										oninput     = "calculaCapAbaMerc(this)"
									>
								</div>
							</div>
						</div>
						{{-- Mercado Objetivo --}}
						<div class="col-lg-6 col-md-6 col-sm-6 align-center" style="margin-bottom: 0px !important">
							<h4 class=col-cyan>{{ __('messages.mercObje') }}</h4>
								<h4 class="align-center"><span id="labelCapAbaMerc">0 </span>{{ __('messages.personas') }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		{{-- Unidades razonables de consumo potencial anual por persona --}}
		<div id="divUniRazCon" class="col-lg-6" style="visibility: hidden;">
			<div class="card">
				<div class="body">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6" style="margin-bottom: 0px !important">
							<br>
							<div class="form-group form-float" style="margin-bottom: 5px !important">
								<div class="form-line">
									<small><label>{{ __('messages.uniConsPot') }}</label></small>
									<input 
										type        = "number"
										id          = "txtuniConsPot"
										min         = "1"
										step        = "1"
										class       = "form-control"
										placeholder = "Ej. 30%"
										value       = 0
										oninput     = "calcularConsumoAnual(this)"
										onkeypress  = "return checaEnter(event, 'ProyVen')"
									>
								</div>
							</div>
						</div>
						{{-- Mercado Objetivo --}}
						<div class="col-lg-6 col-md-6 col-sm-6 align-center" style="margin-bottom: 0px !important">
							<h4 class=col-cyan>{{ __('messages.consAnualMerc') }}</h4>
								<h4 class="align-center"><span id="labeluniConsPot">0 </span>{{ trans_choice('messages.unidad', 2) }}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection