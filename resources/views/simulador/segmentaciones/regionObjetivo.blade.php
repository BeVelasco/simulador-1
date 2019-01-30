<div class="container-fluid">
	<h2 class="align-center col-pink">{{ __('messages.regionObj') }}</h2>
	<div class="col-lg-2 col-md-2"></div>
	<div class="col-lg-8 col-md-8">
		<div class="card">
			<div class="body" style="padding-bottom: 0px !important;">
				<form id="formPV1">
					<fieldset>
						<!-- Primer fila de campos -->
						<div class="form-group form-float" style="margin-bottom: 25px !important;">
							<div class="row">
								<!-- txt Estado -->
								<div class="col-sm-6 col-lg-6 col-md-6">
									<div class="form-line">
										<input
											id         = "txtEstado"
											type       = "text"
											class      = "form-control"
											value      = ""
											onkeypress = "return checaEnter(event, '1')"
											required
											autofocus
										>
										<label class="form-label">{{ __('messages.estado') }}</label>
									</div>
								</div>
								<!-- txt Personas -->
								<div class="col-sm-6 col-lg-6 col-md-6">
									<div class="form-line">
										<input
											id         = "txtPersonas"
											type       = "number"
											class      = "form-control"
											onkeypress = "return checaEnter(event, '1')"
											min        = "1"
											step       = "1"
											value      = ""
											required
										>
										<label class="form-label">{{ __('messages.personas') }}</label>
									</div>
								</div>
							</div>
						</div>
						<!-- Segunda fila de campos -->
						<div class="form-group form-float">
							<div class="row">
								<div class="col col-sm-4 col-lg-4 col-md-4">
									<div class="form-line">
										<input
											id         = "txtCiudadObjetivo"
											type       = "text"
											class      = "form-control"
											onkeypress = "return checaEnter(event, '1')"
											value      = ""
											required
										>
										<label class="form-label">{{ __('messages.ciudadObj') }}</label>
									</div>
								</div>
								<div class="col col-sm-4 col-lg-4 col-md-4">
									<div class="form-line">
										<div class="form-line">
											<input
												id         = "txtPorcentaje"
												type       = "number"
												class      = "form-control"
												onkeypress = "return checaEnter(event, '1')"
												value      = ""
												max        = "100"
												min        = "0.01"
												step       = "0.01"
												required
											>
											<label class="form-label">%</label>
										</div>
									</div>
								</div>
								<div class="col col-sm-4 col-lg-4 col-md-4">
									<div class="form-line">
										<div class="form-line">
											<input id="txtPerCiuObj" type="number" class="form-control" disabled>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<br>
								<div class="col-lg-3"></div>
								<div class="col-sm-12 col-lg-9">
									<div class="row clearfix align-right">
										<button id="btn1" type="button" class="btn btn-primary waves-effect" onclick="javascript:calcularRegionObjetivo();">{{ __('messages.calcular') }}</button>&nbsp;&nbsp;
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