{{-- Plantilla de Segmentación por Género --}}
@section('content')
	{{'spg'}}
	<h2 class="align-center col-pink">{{ __('messages.spg') }}</h2>
	<div class="container-fluid">
		<div class="col-lg-8 col-md-8">
			<div class="card">
				<div class="body">
					<form>
						<fieldset>
							<input type="text" hidden id="val1">
							<input type="text" hidden id="val2">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6">
									<div class="form-group form-float">
										<div class="form-line">
											<small><label>{{ __('messages.hombresEAC') }}</label></small>
											<input 
												id          = "txtHombresEcoAct"
												type        = "number"
												min         = "0.01"
												max         = "100"
												step        = "0.01"
												class       = "form-control"
												placeholder = "Ej. 30%"
												oninput     = "sumaSeg(this, 1)"
												onkeypress  = "return checaEnter(event, 'NivelSocioEco')"
												autofocus
											>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6">
									<div class="form-group form-float">
										<div class="form-line">
											<small><label>{{ __('messages.total') }} {{ __('messages.hombresEAC') }}</label></small>
											<input
												id          = "txtTotalHombresEcoAct"
												type        = "text"
												class       = "form-control"
												value       = "0 personas"
												disabled
											>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6">
									<div class="form-group form-float">
										<div class="form-line">
											<small><label>{{ __('messages.mujeresEAC') }}</label></small>
											<input 
												id          = "txtMujeresEcoAct"   
												type        = "number"
												min         = "0.01"
												max         = "100"
												step        = "0.01"
												class       = "form-control"
												placeholder = "Ej. 30%"
												oninput     = "sumaSeg(this, 2)"
												onkeypress  = "return checaEnter(event, 'NivelSocioEco')"
											>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6">
									<div class="form-group form-float">
										<div class="form-line">
											<small><label>{{ __('messages.total') }} {{ __('messages.mujeresEAC') }}</label></small>
											<input
												id          = "txtTotalMujeresEcoAct"
												type        = "text"
												class       = "form-control"
												value       = "0 personas"
												disabled
											>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-4">
			<div class="card">
				<div class="body align-center">
					<h3 class= col-cyan>Población neta</h3>
					<h4><span id="poblacionNeta">0 personas</span></h4>
				</div>
			</div>
		</div>
	</div>
@endsection