@php
	$msgalta0 = Lang::get('messages.msgalta0');
	$msgalta1 = Lang::get('messages.msgalta1');
	$msgalta2 = Lang::get('messages.msgalta2');
	$msgbaja0 = Lang::get('messages.msgbaja0');
	$msgbaja1 = Lang::get('messages.msgbaja1');
	$msgbaja2 = Lang::get('messages.msgbaja2');
	$msgselectiva0 = Lang::get('messages.msgselectiva0');
	$msgselectiva1 = Lang::get('messages.msgselectiva1');
	$msgselectiva2 = Lang::get('messages.msgselectiva2');
	$msgselectiva3 = Lang::get('messages.msgselectiva3');
	$msgambi0 = Lang::get('messages.msgambi0');
	$msgambi1 = Lang::get('messages.msgambi1');
	$msgambi2 = Lang::get('messages.msgambi2');
	$msgambi3 = Lang::get('messages.msgambi3');
	$msgambi4 = Lang::get('messages.msgambi4');
@endphp

<div class="row">
	<h2 class="align-center col-pink">{{ __('messages.mercaTipo') }}</h2>
	<div class="col-lg-2 col-md-2"></div>

	<div class="col-lg-8 col-md-8">
		<!-- Seccion para el tipo de Estrategia-->
		

		<div class="card">
			<div class="body" style="padding-bottom: 0px !important;">
				<form id="formMT1">
					<fieldset>
						<!-- Primer fila de campos -->
						<div class="form-group form-float" style="margin-bottom: 25px !important;">
							<div class="row">
								<!-- Select Estrategia -->
								<div class="col-sm-12 col-lg-12 col-md-12">
									<div class="form-group">
										<!-- Seleccion de lso 3 tipos de estrategias-->
										<select name="tEstrategia" class="tEstrategia" id="tEstrategia" onChange="cambiadesc()">
	  											<option value="1">Penetración Alta</option>
	  											<option value="2">Penetración Selectiva</option>
	  											<option value="3">Penetración Ambiciosa</option>
	  											<option value="4">Penetración Baja</option>
										</select>

										<label class="form-label">{{ __('messages.estrategia') }}</label>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12 col-lg-12 col-md-12" id="tDescripcion">
									<span id='alta'
        								style="display:inline"><p class="text-justify">{{ $msgalta0 }} <br> 
        																			   {{ $msgalta1 }} <br>
        																			   {{ $msgalta2 }}
        																			</p>
        							</span>
        							<span id='baja'
        								style="display:none"><p class="text-justify">{{ $msgbaja0 }} <br>
        																			{{ $msgbaja1 }} <br>
        																			{{ $msgbaja2 }} <br>
        																			</p>
        							</span>
        							<span id='selectiva'
        								style="display:none"><p class="text-justify">{{ $msgselectiva0 }} <br>
        																			{{ $msgselectiva1 }} <br>
        																			{{ $msgselectiva2 }} <br>
        																			{{ $msgselectiva3 }} <br>
        																			</p>
        							</span>
        							<span id='ambi'
        								style="display:none"><p class="text-justify">{{ $msgambi0 }} <br>
        																			{{ $msgambi1 }} <br>
        																			{{ $msgambi2 }} <br>
        																			{{ $msgambi3 }} <br>
        																			{{ $msgambi4 }} <br>
        																			</p>
        							</span>
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
										<button id="btn1" type="button" class="btn btn-primary waves-effect">{{ __('messages.seleccionar') }}</button>&nbsp;&nbsp;
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