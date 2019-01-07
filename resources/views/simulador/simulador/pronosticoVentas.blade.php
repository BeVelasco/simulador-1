@extends('simulador.base')

@section('assets')

@endsection

@section('content')
<meta name = "sinCalculo" content = "{{ __('messages.sincalculo') }}">
<meta name = "pregunta" content = "{{ __('messages.mesInicioNego') }}">
<div class="card">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="header bg-green">
					<h2>
						{{ __('messages.pronVen') }}
						<small>
							{{ Session::get('prodSeleccionado') -> idesc }} para: {{ Session::get('prodSeleccionado') -> porcionpersona }} {{ Session::get('prodSeleccionado') -> catum -> idesc }}
						</small>
					</h2>
				</div>
				<div class="body">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs tab-nav-right" role="tablist">
						<li role="presentation" >
							<a href="#panelPobObj" data-toggle="tab" aria-expanded="true">{{ __('messages.pobObj') }}</a>
						</li>
						<li role="presentation" >
							<a class="li-pronostico" id="liSegementacion" href="#panelSegmentacion" aria-expanded="false">{{ __('messages.segmentacion') }}</a>
						</li>
						<li role="presentation" >
							<a class="li-pronostico" id="liNivelSocioEco" href="#panelNivelSocioEco" aria-expanded="false">{{ __('messages.nse') }}</a>
						</li>
						<li role="presentation" >
							<a class="li-pronostico" id="liEstimDem" href="#panelEstimDem" aria-expanded="false">{{ __('messages.estimDeman') }}</a>
						</li>
						<li role="presentation" >
							<a class="li-pronostico" id="liProyVen" href="#panelProyVen" aria-expanded="false">{{ __('messages.proyVen') }}</a>
						</li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<!-- Tab Poblacion Obejtivo -->
						<div role="tabpanel" class="tab-pane fade active in" id="panelPobObj">
							@include('simulador.segmentaciones.regionObjetivo')
						</div>
						{{-- Tab de Segmentación --}}
						<div role="tabpanel" class="tab-pane fade" id="panelSegmentacion">
							<span clas="contenidosPronostico" id="contenidoSegmentacion"></span>
							{{-- Botón de siguiente --}}
							<div class="sm-12 align-right" id="divBtnSiguiente">
								<button	type="button" class="btn bg-blue waves-effect" onclick="javascript:showVista('NivelSocioEco')">
									<i class="material-icons">verified_user</i>
									<span>{{ __('messages.siguiente') }}</span>
								</button>
								&nbsp;
								&nbsp;
							</div>
						</div>
						{{-- Tab de Nivel Socioeconomico --}}
						<div role="tabpanel" class="tab-pane fade" id="panelNivelSocioEco">
							<span clas="contenidosPronostico" id="contenidopanelNivelSocioEco"></span>
							{{-- Botón de siguiente --}}
							<div class="sm-12 align-right" id="divBtnSiguiente">
								<button	type="button" class="btn bg-blue waves-effect" onclick="javascript:showVista('EstimDem')">
									<i class="material-icons">verified_user</i>
									<span>{{ __('messages.siguiente') }}</span>
								</button>
								&nbsp;
								&nbsp;
							</div>
						</div>
						{{-- Tab de Mercado disponible --}}
						<div role="tabpanel" class="tab-pane fade" id="panelEstimDem">
							<div clas="contenidosPronostico" id="contenidopanelEstimDem"></div>
							{{-- Botón de siguiente --}}
							<div class="sm-12 align-right" id="divBtnSiguiente">
								<button	type="button" class="btn bg-blue waves-effect" onclick="javascript:showVista('ProyVen')">
									<i class="material-icons">verified_user</i>
									<span>{{ __('messages.siguiente') }}</span>
								</button>
								&nbsp;
								&nbsp;
							</div>
						</div>
						{{-- Tab de Proyecciones de Veta --}}
						<div role="tabpanel" class="tab-pane fade" id="panelProyVen">
							<div clas="contenidosPronostico" id="contenidopanelProyVen"></div>
							{{-- Botón de siguiente 
							<div class="sm-12 align-right" id="divBtnSiguiente">
								<button	type="button" class="btn bg-blue waves-effect" onclick="javascript:showMercDisp()">
									<i class="material-icons">verified_user</i>
									<span>{{ __('messages.siguiente') }}</span>
								</button>
								&nbsp;
								&nbsp;
							</div>--}}
						</div>
					</div>
				</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('js/simuladorScriptsSegmentacion.js') }}"></script>
@endsection