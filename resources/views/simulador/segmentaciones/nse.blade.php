{{-- Plantilla de Nivel socioeconmico --}}
@section('content')
@php
	$nombres=[
		0 => Lang::get('messages.nsea'),
		1 => Lang::get('messages.nseb'),
		2 => Lang::get('messages.nsec'),
		3 => Lang::get('messages.nsec+'),
		4 => Lang::get('messages.nsed'),
		5 => Lang::get('messages.nsed+'),
		6 => Lang::get('messages.nsee'),
	];
@endphp
{{'nse'}}
<h2 class="align-center col-pink">{{ __('messages.segNSE') }}</h2>
	<div class="container-fluid">
		<div class="col-lg-1 col-md-1"></div>
		<div class="col-lg-7 col-md-7">
			<div class="card">
				<div class="body">
					<form>
						<fieldset>
							@foreach($nombres as $nombre)
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6" style="margin-bottom: 0px !important">
										<div class="form-group form-float" style="margin-bottom: 5px !important">
											<div class="form-line">
												<small>
												<label>{{ $nombre }}</label>
												<input 
													type        = "number"
													id          = "txtNse{{ $loop->iteration }}"
													min         = "0.00"
													max         = "100"
													step        = "1"
													class       = "form-control classTxtNse"
													placeholder = "Ej. 30%"
													oninput     = "sumaNse(this, {{ $loop->iteration }})"
													onkeypress  = "return checaEnter(event, 'EstimDem')"
												></small>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6" style="margin-bottom: 0px !important">
										<div class="form-group form-float" style="margin-bottom: 5px !important">
											<div class="form-line">
												<small>
												<label>{{ $nombre }}</label>
												<input 
													type        = "text"
													id          = "txtTotalNse{{ $loop->iteration }}"
													class       = "form-control txtTotalNse"
													value       = "0 personas"
													disabled    = "" 
												></small>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-3">
			<div class="card">
				<div class="body align-center">
					<h4 class=col-cyan>{{ __('messages.mercadoPotencial') }}</h3>
					<h4><span id="totalPoblacionNse">0 personas</span></h4>
				</div>
			</div>
		</div>
	</div>
@endsection