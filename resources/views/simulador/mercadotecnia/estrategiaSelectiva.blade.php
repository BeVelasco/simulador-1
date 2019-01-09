@extends('base')

@section('assets')

@endsection

@section('content')
<meta name = "sinCalculo"   content = "{{ __('messages.sincalculo') }}">
<div class="card">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="header bg-green">
					<h2>
						{{ __('messages.merca') }}
						<small>
							{{ Session::get('prodSeleccionado') -> idesc }} para: {{ Session::get('prodSeleccionado') -> porcionpersona }} {{ Session::get('prodSeleccionado') -> catum -> idesc }}
						</small>
					</h2>
				</div>
				<div class="body">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs tab-nav-right" role="tablist">
						<li role="presentation" class="active">
							<a href="#panelMerca" data-toggle="tab" aria-expanded="true">Estrategia</a>
						</li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<!-- Tab Estrategia -->
						<div role="tabpanel" class="tab-pane fade active in" id="panelMerca">
							@include('simulador.mercadotecnia.estrategiaSelectivaVista')
						</div>
						
						
						{{-- Tab de Proyecciones de Veta --}}
						<div role="tabpanel" class="tab-pane fade" id="panelProyVen">
							<div id="contenidopanelProyVen"></div>
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
	<script src="{{ asset('js/simuladorScriptsMerca.js') }}"></script>
@endsection