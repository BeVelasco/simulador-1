<div class="row">
	<h2 class="align-center col-pink">{{ __('messages.estrategiaSelect') }}</h2>
	<div class="col-lg-2 col-md-2"></div>

	<div class="col-lg-9 col-md-9">
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
									<p class="text-justify">{{ __('messages.selecprecio') }}</p>
								</div>
								<div class="col-sm-4 col-lg-4 col-md-4">
									<div class="form-group form-float no-bottom-padding">
										<div class="form-line">
											<input 
												type        = "number"
												id          = "txtprecio"
												min         = "1"
												max         = "100000"
												step        = "1"
												class       = "form-control"
												value       = "0"
											>
										</div>
										<label class="form-label">{{ __('messages.costanual') }}</label>
									</div>
								</div>
							
								<div class="col-sm-8 col-lg-8 col-md-8">
									<label class="form-label">{{ __('messages.canales') }}</label>
									<p class="text-justify">{{ __('messages.seleccanales') }}</p>
								</div>
								<div class="col-sm-4 col-lg-4 col-md-4">
									<div class="form-group form-float no-bottom-padding">
										<div class="form-line">
											<input 
												type        = "number"
												id          = "txtcanal"
												min         = "1"
												max         = "1000090"
												step        = "1"
												class       = "form-control"
												value       = "0"
											>
										</div>
										<label class="form-label">{{ __('messages.costanual') }}</label>
									</div>
								</div>

								<div class="col-sm-8 col-lg-8 col-md-8">
									<label class="form-label">{{ __('messages.producto') }}</label>
									<p class="text-justify">{{ __('messages.selecproducto') }}</p>
								</div>
								<div class="col-sm-4 col-lg-4 col-md-4">
									<div class="form-group form-float no-bottom-padding">
										<div class="form-line">
											<input 
												type        = "number"
												id          = "txtproducto"
												min         = "1"
												max         = "100000"
												step        = "1"
												class       = "form-control"
												value       = "0",
												readonly    = "readonly" 
											>
										</div>
										<label class="form-label">{{ __('messages.costanual') }}</label>
									</div>
								</div>

								<div class="col-sm-8 col-lg-8 col-md-8">
									<label class="form-label">{{ __('messages.promocion') }}</label>
									<p class="text-justify">{{ __('messages.selecpromocion') }}</p>
								</div>
								<div class="col-sm-4 col-lg-4 col-md-4">
									<div class="form-group form-float no-bottom-padding">
										<div class="form-line">
											<input 
												type        = "number"
												id          = "txtpromocion"
												min         = "1"
												max         = "100000"
												step        = "1"
												class       = "form-control"
												value       = "0"
											>
										</div>
										<label class="form-label">{{ __('messages.costanual') }}</label>
									</div>
								</div>

								<div class="col-sm-8 col-lg-8 col-md-8">
									<label class="form-label">{{ __('messages.relaciones') }}</label>
									<p class="text-justify">{{ __('messages.selecrelaciones') }}</p>
								</div>
								<div class="col-sm-4 col-lg-4 col-md-4">
									<div class="form-group form-float no-bottom-padding">
										<div class="form-line">
											<input 
												type        = "number"
												id          = "txtrelaciones"
												min         = "1"
												max         = "100000"
												step        = "1"
												class       = "form-control"
												value       = "0"
											>
										</div>
										<label class="form-label">{{ __('messages.costanual') }}</label>
									</div>
								</div>

								<div class="col-sm-8 col-lg-8 col-md-8">
									<label class="form-label">{{ __('messages.ClientesI') }}</label>
									<p class="text-justify">{{ __('messages.selecclientesi') }}</p>
								</div>
								<div class="col-sm-4 col-lg-4 col-md-4">
									<div class="form-group form-float no-bottom-padding">
										<div class="form-line">
											<input 
												type        = "number"
												id          = "txtclientesi"
												min         = "1"
												max         = "100000"
												step        = "1"
												class       = "form-control"
												value       = "0"
											>
										</div>
										<label class="form-label">{{ __('messages.costanual') }}</label>
									</div>
								</div>

								<!-- Totalizado-->
								<div class="col col-sm-4 col-lg-4 col-md-4">
									<div class="form-line">
										<div class="form-line">
											<input id="txtTotal" type="number" class="form-control" value="0" readonly="readonly">
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
										<button id="btnt" type="button" class="btn btn-primary waves-effect">{{ __('messages.seleccionar') }}</button>&nbsp;&nbsp;
									</div>
								</div>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>