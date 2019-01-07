{{-- Platilla de Población Económicamente Activa --}}
@section('content')
{{'pea'}}
	<h2 class="align-center col-pink">{{ __('messages.pea') }}</h2>
	<div class="row">
		<div class="col-lg-8 col-md-8">
			<div class="card">
				<div class="body">
					<form id="formPEA">
						<fieldset>
							<input type="text" hidden id="val1">
							<input type="text" hidden id="val2">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6">
									<div class="form-group form-float">
										<div class="form-line">
											<small><label>{{ __('messages.porcentajeDe') }} {{ __('messages.pea') }}</label></small>
											<input 
												type        = "number"
												id          = "txtPorcPobEcoAct"
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
											<small><label>{{ __('messages.total') }}</label></small>
											<input
												id          = "txtTotalPorcPobEcoAct"
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
											<small><label>{{ __('messages.impactoOtros') }}</label></small>
											<input 
												type        = "number"
												id          = "txtImpactoRegional"
												min         = "0.01"
												max         = "100"
												step        = "0.01"
												class       = "form-control"
												placeholder = "Ej. 30%"
												oninput     = "sumaSeg(this, 2)"
											>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6">
									<div class="form-group form-float">
										<div class="form-line">
											<small><label>{{ __('messages.total') }}</label></small>
											<input
												id          = "txtTotalImpactoRegional"
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
					<h3 class= col-cyan>{{ __('messages.poblacionNeta') }}</h3>
					<h4><span id="poblacionNeta">0</span> {{ __('messages.personas') }}</h4>
				</div>
			</div>
		</div>
	</div>
@endsection