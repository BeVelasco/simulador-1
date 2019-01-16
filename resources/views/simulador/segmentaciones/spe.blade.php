{{-- Plantilla de Segmentación por Edad --}}
@section('content')
@php
$textos =[
	1  => Lang::get('messages.ninos04'),
	2  => Lang::get('messages.ninos59'),
	3  => Lang::get('messages.ninos1014'),
	4  => Lang::get('messages.hombres1519'),
	5  => Lang::get('messages.hombres2029'),
	6  => Lang::get('messages.hombres3039'),
	7  => Lang::get('messages.hombres4049'),
	8  => Lang::get('messages.hombres5070'),
	9  => Lang::get('messages.hombres70100'),	
	10 => Lang::get('messages.ninas04'),
	11 => Lang::get('messages.ninas59'),
	12 => Lang::get('messages.ninas1014'),
	13 => Lang::get('messages.mujeres1519'),
	14 => Lang::get('messages.mujeres2029'),
	15 => Lang::get('messages.mujeres3039'),
	16 => Lang::get('messages.mujeres4049'),
	17 => Lang::get('messages.mujeres5070'),
	18 => Lang::get('messages.mujeres70100'),
];
@endphp
	{{'spe'}}
	<h2 class="align-center col-pink">{{ __('messages.spe') }}</h2>
	<div class="container-fluid">
		<div class="col-lg-4 col-md-4">
			<div class="card">
				<div class="body" id="divHombres">
					<form>
						<fieldset>
							<input type="text" hidden id="val1">
							<input type="text" hidden id="val2">
							@for ($i = 1; $i < 10; $i++)
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 no-bottom-padding">
										<div class="form-group form-float no-bottom-padding">
											<div class="form-line">
												<small><label>{{ $textos[$i] }}</label></small>
												<input 
													type        = "number"
													id          = "txtSpeHombres{{ $i }}"
													class       = "classTxtSpeHombres"
													min         = "0.01"
													max         = "100"
													step        = "0.01"
													class       = "form-control"
													value       = 0
													oninput     = "sumaSeg(this, 5)"
												>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 no-bottom-padding">
										<div class="form-group form-float no-bottom-padding">
											<div class="form-line">
												<small>
													<label>
														{{ __('messages.total') }}
													</label>
												</small>
												<input
													id          = "txtTotalSpeHombres{{ $i }}"
													type        = "text"
													class       = "form-control font-12"
													value       = "0 personas"
													disabled
												>
											</div>
										</div>
									</div>
								</div>
							@endfor
							<b><p id="divTotalhombres" class="align-right font-20"></p></b>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-4">
			<div class="card">
				<div class="body">
					<form>
						<fieldset>
							<input type="text" hidden id="val1">
							<input type="text" hidden id="val2">
							@for ($i = 10; $i < 19; $i++)
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 no-bottom-padding">
										<div class="form-group form-float no-bottom-padding">
											<div class="form-line">
												<small><label>{{ $textos[$i] }}</label></small>
												<input 
													type        = "number"
													id          = "txtSpeMujeres{{ $i }}"
													class       = "classTxtSpeMujeres"
													min         = "0.01"
													max         = "100"
													step        = "0.01"
													class       = "form-control"
													value       = 0
													oninput     = "sumaSeg(this, 5)"
												>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 no-bottom-padding">
										<div class="form-group form-float no-bottom-padding">
											<div class="form-line">
												<small>
													<label>
														{{ __('messages.total') }}
													</label>
													</small>
												<input
													id          = "txtTotalSpeMujeres{{ $i }}"
													type        = "text"
													class       = "form-control font-12"
													value       = "0 personas"
													disabled
												>
											</div>
										</div>
									</div>
								</div>
							@endfor
							<b><p id="divTotalmujeres" class="align-right font-20"></p></b>
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