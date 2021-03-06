
<h2 class="align-center col-pink">{{ __('messages.estrategiaAlta') }}</h2>
<div class="col-lg-2 col-md-2"></div>
<div class="col-lg-8 col-md-8">
	<!-- Seccion para el tipo de Estrategia-->
	<div class="card">
		<div class="body" style="padding-bottom: 0px !important;">
			<form id="formMT1">
				<fieldset>
					<!-- Primer fila de campos -->
					<div class="form-group form-float" style="margin-bottom: 25px !important;">
						<!-- Costos a obtener-->
						<div class="row">
							<div class="col-sm-8 col-lg-8 col-md-8">
								<label class="form-label">{{ __('messages.precio') }}</label>
								<p class="text-justify">{{ __('messages.altaprecio') }}</p>
							</div>
							<div class="col-sm-4 col-lg-4 col-md-4">
								<div class="form-group form-float no-bottom-padding">
									<div class="form-line">
										<input 
											type       = "number"
											id         = "txtPrecioAlta"
											min        = "1"
											max        = "100000"
											step       = "1"
											class      = "form-control inputAlta"
											value      = ""
											onkeyup    = "suma(this)"
											onkeypress = "eliminaEInput(event)"
											required
										>
									</div>
									<label class="form-label">{{ __('messages.costanual') }}</label>
								</div>
							</div>
							<div class="col-sm-8 col-lg-8 col-md-8">
								<label class="form-label">{{ __('messages.canales') }}</label>
								<p class="text-justify">{{ __('messages.altacanales') }}</p>
							</div>
							<div class="col-sm-4 col-lg-4 col-md-4">
								<div class="form-group form-float no-bottom-padding">
									<div class="form-line">
										<input 
											type       = "number"
											id         = "txtCanalAlta"
											min        = "0"
											max        = "100000"
											step       = "1"
											class      = "form-control inputAlta"
											value      = "0"
											onkeyup    = "suma(this)"
											onkeypress = "eliminaEInput(event)"
											required
										>
									</div>
									<label class="form-label">{{ __('messages.costanual') }}</label>
								</div>
							</div>
							<div class="col-sm-8 col-lg-8 col-md-8">
								<label class="form-label">{{ __('messages.producto') }}</label>
								<p class="text-justify">{{ __('messages.altaproducto') }}</p>
							</div>
							<div class="col-sm-4 col-lg-4 col-md-4">
								<div class="form-group form-float no-bottom-padding">
									<div class="form-line">
										<input 
											type       = "number"
											id         = "txtProductoAlta"
											min        = "0"
											max        = "100000"
											step       = "1"
											class      = "form-control inputAlta"
											value      = "0"
											onkeyup    = "suma(this)"
											onkeypress = "eliminaEInput(event)"
										>
									</div>
									<label class="form-label">{{ __('messages.costanual') }}</label>
								</div>
							</div>
							<div class="col-sm-8 col-lg-8 col-md-8">
								<label class="form-label">{{ __('messages.promocion') }}</label>
								<p class="text-justify">{{ __('messages.altapromocion') }}</p>
							</div>
							<div class="col-sm-4 col-lg-4 col-md-4">
								<div class="form-group form-float no-bottom-padding">
									<div class="form-line">
										<input 
											type       = "number"
											id         = "txtPromocionAlta"
											min        = "1"
											max        = "100000"
											step       = "1"
											class      = "form-control inputAlta"
											value      = "0"
											onkeyup    = "suma(this)"
											onkeypress = "eliminaEInput(event)"
										>
									</div>
									<label class="form-label">{{ __('messages.costanual') }}</label>
								</div>
							</div>
							<div class="col-sm-8 col-lg-8 col-md-8">
								<label class="form-label">{{ __('messages.relaciones') }}</label>
								<p class="text-justify">{{ __('messages.altarelaciones') }}</p>
							</div>
							<div class="col-sm-4 col-lg-4 col-md-4">
								<div class="form-group form-float no-bottom-padding">
									<div class="form-line">
										<input 
											type       = "number"
											id         = "txtRelacionesAlta"
											min        = "1"
											max        = "100000"
											step       = "1"
											class      = "form-control inputAlta"
											value      = "0"
											onkeyup    = "suma(this)"
											onkeypress = "eliminaEInput(event)"
										>
									</div>
									<label class="form-label">{{ __('messages.costanual') }}</label>
								</div>
							</div>
							<div class="col-sm-8 col-lg-8 col-md-8">
								<label class="form-label">{{ __('messages.ClientesI') }}</label>
								<p class="text-justify">{{ __('messages.altaclientesi') }}</p>
							</div>
							<div class="col-sm-4 col-lg-4 col-md-4">
								<div class="form-group form-float no-bottom-padding">
									<div class="form-line">
										<input 
											type       = "number"
											id         = "txtClientesiAlta"
											min        = "1"
											max        = "100000"
											step       = "1"
											class      = "form-control inputAlta"
											value      = "0"
											onkeyup    = "suma(this)"
											onkeypress = "eliminaEInput(event)"
										>
									</div>
									<label class="form-label">{{ __('messages.costanual') }}</label>
								</div>
							</div>
							<!-- Totalizado-->
							<div class="col col-sm-8 col-lg-8 col-md-8"></div>
							<div class="col col-sm-4 col-lg-4 col-md-4">
								<div class="form-line">
									<div class="form-line">
										<input id="txtTotalAlta" type="number" class="form-control" value="0" readonly="readonly">
										<label class="form-label">Total {{ __('messages.anual') }}</label>
									</div>
								</div>
							</div>
							
						</div>
					</div>
					<!-- Segunda fila de campos -->
					<div class="form-group form-float">
						<div class="row">
							<br>
							<div class="col-lg-3"></div>
							<div class="col-sm-12 col-lg-9">
								<div class="row clearfix align-right">
									<button id="btnt" type="button" class="btn btn-primary waves-effect" onclick="guardaMerca()">{{ __('messages.seleccionar') }}</button>&nbsp;&nbsp;
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
