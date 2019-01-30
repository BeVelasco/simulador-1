@extends('base')
@section('assets')
    <link href="{{ asset('plugins/vertical-timeline/vertical-timeline.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style_tablero.css') }}" rel="stylesheet">
    <style>
        .tablero-button{
            color:#9e9e9e
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Example Tab -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            PANEL DE CONTROL
                        </h2>
                    </div>
                    <div class="body">
						<!-- Nav tabs principal-->
						<!--<ul class="nav nav-tabs tab-nav-right tab-col-teal" role="tablist">
                            <li role="presentation" class="active"><a href="#simulador" data-toggle="tab">
								<div>
									<b>Simulador</b>
								</div>
							</a></li>
                            <li role="presentation"><a href="#asesorias" data-toggle="tab">
								<div >
									<b>Asesorías</b>
								</div>
							</a></li>
                        </ul>-->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade active in" id="simulador">
								<!-- Nav tabs simulador -->
								<ul class="nav nav-tabs tab-nav-right" role="tablist">

								</ul>
								<div class="tab-content" id="tab-content">
								</div>

							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="asesorias">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- #END# Example Tab -->

	<!-- #END# Tabs With Custom Animations -->
</div>
@endsection

@section('scripts')
    <script src="{{ asset('plugins/vertical-timeline/vertical-timeline.js') }}"></script>
	<script src="{{ asset('js/tableroScripts.js') }}"></script>
@endsection
