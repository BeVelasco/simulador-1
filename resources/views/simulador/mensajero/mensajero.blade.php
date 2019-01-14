@extends('base')
@section('assets')
	<link href="{{ asset('css/style_mensajero.css') }}" rel="stylesheet">
@endsection
@section('content')
    
    <div class="container-fluid">
        
		<div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            MENSAJES
                        </h2>
                    </div>
                    <div class="body">
						<div id="messages" class="container-fluid">
							<div class="row" id="test">
								<div class="col-xs-12">
									<div class="row">
										<ul id="messages-menu" class="nav msg-menu">
											<li>
												<a href="#" class="msg-recibidos" data-tipo="I" id="msg-inbox">
													<i class="fa fa-inbox"></i>
													<span class="hidden-xs">Entrada</span>
												</a>
											</li>
											<li>
												<a href="#" class="msg-recibidos" data-tipo="D" id="msg-stared">
													<i class="fa fa-bookmark"></i>
													<span class="hidden-xs">Destacados</span>
												</a>
											</li>
											<li>
												<a href="#" class="msg-recibidos" data-tipo="E" id="msg-sent">
													<i class="fa fa-reply"></i>
													<span class="hidden-xs">Enviados</span>
												</a>
											</li>
                                            <li>
												<a href="#" class="msg-recibidos" data-tipo="A" id="msg-archived">
													<i class="fa fa-archive"></i>
													<span class="hidden-xs">Archivados</span>
												</a>
											</li>                                            
										</ul>
										<div id="messages-list" class="col-xs-10 col-xs-offset-2">
										  <div id="divResultado"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@include('simulador.mensajero.modals.addMensaje')
@endsection

@section('scripts')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('plugins/jquery-datatable/datatables.js') }}"></script>
    <script src="{{ asset('plugins/jquery-datatable/DataTables-1.10.16/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('plugins/jquery-datatable/Buttons-1.5.1/js/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('plugins/jquery-datatable/Buttons-1.5.1/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-datatable/JSZip-2.5.0/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-datatable/pdfmake-0.1.32/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-datatable/pdfmake-0.1.32/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/jquery-datatable/Buttons-1.5.1/js/buttons.html5.js') }}"></script>
    <script src="{{ asset('plugins/jquery-datatable/Buttons-1.5.1/js/buttons.print.js') }}"></script>
    <script src="{{ asset('plugins/jquery-datatable/Select-1.2.5/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-datatable/plugins/sum.js') }}"></script>
    
	<script src="{{ asset('js/mensajeroScripts.js') }}"></script>
@endsection