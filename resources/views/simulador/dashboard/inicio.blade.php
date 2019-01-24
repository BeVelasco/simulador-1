@extends('base')
@section('assets')
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
									<li role="presentation" class="active"><a href="{{route('home')}}" data-toggle="tab">
										<div class="irs-demo">
											<b>Oso grande</b>
											<input type="text" id="range_01" value="50" class="ion-range"/>
										</div>
									</a></li>
									<li role="presentation"><a href="#profile" data-toggle="tab">
										<div class="irs-demo">
											<b>Oso mediano</b>
											<input type="text" id="range_02" value="40" class="ion-range" />
										</div>
									</a></li>
									<li role="presentation"><a href="#messages" data-toggle="tab">
										<div class="irs-demo">
											<b>Puff</b>
											<input type="text" id="range_03" value="80" class="ion-range" />
										</div>
									</a></li>
									<li role="presentation"><a href="#settings" data-toggle="tab">
										<div class="irs-demo">
											<b>Vestido 3 años</b>
											<input type="text" id="range_04" value="30" class="ion-range" />
										</div>
									</a></li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane fade active in" id="home">

										<div class="col-sm-12">
											<div class="col-sm-3">
                                                <a class="tablero-button" href="{{ route('home') }}">
													<span class="titulo">Costeo de productos</span>
                                                    <br /><br />
                                                    <i class="fa fa-dollar-sign fa-4x"></i>
												</a>


											</div>
											<div class="col-sm-3">
												<div id="waterBall1" class="waterBall" style="width: 100px;height:100px; float:left"></div>
											</div>
											<div class="col-sm-6 timeline-area">
												<div id="timeline1" class="timeline" style="overflow: auto;padding: 100px !important;"> </div>
											</div>

											<div class="row"></div>
											<div class="col-sm-3">
                                                <a class="tablero-button" href="{{ route('home') }}">
													<span class="titulo">Pronóstico de ventas</span>
                                                    <br /><br />
                                                    <i class="fa fa-diagnoses fa-4x"></i>
												</a>
											</div>
											<div class="col-sm-3">
												<div id="waterBall2" class="waterBall" style="width: 100px;height:100px; float:left"></div>
											</div>
											<div class="col-sm-6 timeline-area">
												<div id="timeline2" class="timeline" style="overflow: auto;padding: 100px !important;"> </div>
											</div>

											<div class="row"></div>
											<div class="col-sm-3">
                                                <a class="tablero-button" href="{{ route('home') }}">
													<span class="titulo">Inventarios</span>
                                                    <br /><br />
                                                    <i class="fa fa-warehouse fa-4x"></i>
												</a>

											</div>
											<div class="col-sm-3">
												<div id="waterBall3" class="waterBall" style="width: 100px;height:100px; float:left"></div>
											</div>
											<div class="col-sm-6 timeline-area">
												<div id="timeline3" class="timeline" style="overflow: auto;padding: 100px !important;"> </div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane fade" id="profile">
										<b>Contenido</b>
										<p>

										</p>
									</div>
									<div role="tabpanel" class="tab-pane fade" id="messages">
										<b>Contenido</b>
										<p>

										</p>
									</div>
									<div role="tabpanel" class="tab-pane fade" id="settings">
										<b>Contenido</b>
										<p>

										</p>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="profile">
									<b>Profile Content</b>
									<p>
										Lorem ipsum dolor sit amet, ut duo atqui exerci dicunt, ius impedit mediocritatem an. Pri ut tation electram moderatius.
										Per te suavitate democritum. Duis nemore probatus ne quo, ad liber essent aliquid
										pro. Et eos nusquam accumsan, vide mentitum fabellas ne est, eu munere gubergren
										sadipscing mel.
									</p>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="messages">
									<b>Message Content</b>
									<p>
										Lorem ipsum dolor sit amet, ut duo atqui exerci dicunt, ius impedit mediocritatem an. Pri ut tation electram moderatius.
										Per te suavitate democritum. Duis nemore probatus ne quo, ad liber essent aliquid
										pro. Et eos nusquam accumsan, vide mentitum fabellas ne est, eu munere gubergren
										sadipscing mel.
									</p>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="settings">
									<b>Settings Content</b>
									<p>
										Lorem ipsum dolor sit amet, ut duo atqui exerci dicunt, ius impedit mediocritatem an. Pri ut tation electram moderatius.
										Per te suavitate democritum. Duis nemore probatus ne quo, ad liber essent aliquid
										pro. Et eos nusquam accumsan, vide mentitum fabellas ne est, eu munere gubergren
										sadipscing mel.
									</p>
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
	<script src="{{ asset('js/tableroScripts.js') }}"></script>
@endsection
