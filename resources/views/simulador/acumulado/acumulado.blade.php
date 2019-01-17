@extends('base')

@section('assets')
@endsection

@section('content')
	<div class="card">
		<div class="header bg-pink">
			<h2>
				{{ Session::get('prodSeleccionado') -> idesc }}
				<small>
					Para: {{ Session::get('prodSeleccionado') -> porcionpersona }} {{ Session::get('prodSeleccionado') -> catum -> idesc }}
				</small>
			</h2>
		</div>
		<div class="body">
            <div class="row">
				<div class="sm-12 align-right" id="divBtnSiguiente">
					<ul class="toolbar-form">
           				<li>
        					<button type="button" class="btn bg-blue waves-effect" onclick="javascript:regresar();">
        						<i class="material-icons">arrow_back</i>
        						<span>{{ __('messages.regresar') }}</span>
        					</button>
        				</li>
        			</ul>
				</div>
			</div>
            
			<div class="row clearfix">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    				<div class="card">
                        <div class="header bg-red">
                            <h2>
                                Insumos
                            </h2>
                        </div>
                        <div class="body">
                            <table id="tablainsumos" class="table table-striped table-bordered dataTable no-footer" role="grid" style="width: 100%;"></table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    				<div class="card">
                        <div class="header bg-cyan">
                            <h2>
                                Formulación
                            </h2>
                        </div>
                        <div class="body">
                            <table id="tablaformulacion" class="table table-striped table-bordered dataTable no-footer" role="grid" style="width: 100%;"></table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    				<div class="card">
                        <div class="header bg-green">
                            <h2>
                                Ventas mensuales
                            </h2>
                        </div>
                        <div class="body">
                            <table id="tablaventas" class="table table-striped table-bordered dataTable no-footer" role="grid" style="width: 100%;"></table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row clearfix">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    				<div class="card">
                        <div class="header bg-green">
                            <h2>
                                Unidades vendidas
                            </h2>
                        </div>
                        <div class="body">
                            <table id="tablaunidades" class="table table-striped table-bordered dataTable no-footer" role="grid" style="width: 100%;"></table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    				<div class="card">
                        <div class="header bg-orange">
                            <h2>
                                Costo de materia prima
                            </h2>
                        </div>
                        <div class="body">
                            <table id="tablacostomp" class="table table-striped table-bordered dataTable no-footer" role="grid" style="width: 100%;"></table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    				<div class="card">
                        <div class="header bg-blue-grey">
                            <h2>
                                Porcentajes
                            </h2>
                        </div>
                        <div class="body">
                            <table id="tablaporcentajes" class="table table-striped table-bordered dataTable no-footer" role="grid" style="width: 100%;"></table>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
	
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
	<script src="{{ asset('js/acumuladoScripts.js') }}"></script>
@endsection