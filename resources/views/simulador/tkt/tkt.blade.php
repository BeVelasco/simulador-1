@extends('base')

@section('assets')
	<link href="{{ asset('css/jExcel/jquery.jcalendar.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jdropdown.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.green.css') }}" rel="stylesheet">
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
            				    <input type="checkbox" id="chkGuardarvacias" class="filled-in"  />
                                <label for="basic_checkbox_2">Guardar con celdas vacías</label>
            			</li>
                        <li>
            				<button type="button" class="btn bg-blue waves-effect" onclick="javascript:Guardar();">
        						<i class="material-icons">save</i>
        						<span>{{ __('messages.guardar') }}</span>
        					</button>
            			</li>
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
                <div class="sm-12">
                    <label class="form-label">FORMULACIÓN DE PROCESO DE NEGOCIO CAPACIDAD INSTALADA PRODUCTO:</label>            
			        <div id="excelformula"></div>
                </div>                     
            </div>
			<div class="row clearfix">
				<div class="col-sm-6 align-right">
					<label class="form-label">TOTAL TAKT TIME POR PRODUCTO POR MINUTOS:</label>
				</div>
                <div  class="col-sm-2 align-left">
                    <div class="form-group form-float">
						<div class="form-line">
							<input 
								id          = "total"
								name        = "total"
								class       = "form-control input-md" 
								type        = "text"
                                readonly
							>
						</div>
					</div>
                </div>
            </div>
            <div class="row clearfix">
				<div class="col-sm-12">
					<label class="form-label">Análisis por empleados en término de producción:</label>
                    <div class="form-group form-float">
						<div class="form-line">
							<input 
								id          = "analisis"
								name        = "analisis"
								class       = "form-control input-md" 
								type        = "text"
							>
						</div>
					</div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="sm-12">
                    <label class="form-label">TIEMPO DE ELABORACIÓN DEL PRODUCTO:</label>            
			        <div id="exceltiempo"></div>
                </div>                     
            </div>
            <div class="row clearfix">
                <div class="sm-12">
                    <label class="form-label">TIEMPOS AGREGADOS:</label>            
			        <div id="excelagregados"></div>
                </div>                     
            </div>
            <div class="row clearfix">
                <div class="sm-12">
                    <label class="form-label">RELACION DE GASTOS INDIRECTOS DE FABRICACIÓN:</label>            
			        <div id="excelgastos"></div>
                </div>                     
            </div>
            <div class="row clearfix">
				<div class="col-sm-12">
					<label class="form-label">Descripción de la maquinaria:</label>
                    <div class="form-group form-float">
						<div class="form-line">
							<input 
								id          = "maquinariadesc"
								name        = "maquinariadesc"
								class       = "form-control input-md" 
								type        = "text"
							>
						</div>
					</div>
                </div>
            </div>
            <div class="row clearfix">
				<div class="col-sm-12">
					<label class="form-label">Tiempo de vida del producto:</label>
                    <div class="form-group form-float">
						<div class="form-line">
							<input 
								id          = "tiempodesc"
								name        = "tiempodesc"
								class       = "form-control input-md" 
								type        = "text"
							>
						</div>
					</div>
                </div>
            </div>
            <div class="row clearfix">
				<div class="col-sm-12">
					<label class="form-label">Número de merma en las líneas de producción:</label>
                    <div class="form-group form-float">
						<div class="form-line">
							<input 
								id          = "mermadesc"
								name        = "mermadesc"
								class       = "form-control input-md" 
								type        = "text"
							>
						</div>
					</div>
                </div>
            </div>
            <div class="row clearfix">
				<div class="col-sm-12">
					<label class="form-label">Si usa algún producto de origen químico favor de indicar cuál es y en dónde lo usa:</label>
                    <div class="form-group form-float">
						<div class="form-line">
							<input 
								id          = "quimicodesc"
								name        = "quimicodesc"
								class       = "form-control input-md" 
								type        = "text"
							>
						</div>
					</div>
                </div>
            </div>
            <div class="row clearfix">
				<div class="col-sm-12">
					<label class="form-label">Qué normas oficiales mexicanas involucra en sus procesos:</label>
                    <div class="form-group form-float">
						<div class="form-line">
							<input 
								id          = "normasdesc"
								name        = "normasdesc"
								class       = "form-control input-md" 
								type        = "text"
							>
						</div>
					</div>
                </div>
            </div>
            <div class="row clearfix">
				<div class="col-sm-12">
					<label class="form-label">Tipo de entrada de almacen:</label>
                    <div class="form-group form-float">
						<div class="form-line">
							<input 
								id          = "entradaalmacendesc"
								name        = "entradaalmacendesc"
								class       = "form-control input-md" 
								type        = "text"
							>
						</div>
					</div>
                </div>
            </div>
            
		</div>
	</div>
	
@endsection

@section('scripts')
	<script src="{{ asset('js/jExcel/jquery.jexcel.js') }}"></script>
	<script src="{{ asset('js/jExcel/excel-formula.min.js') }}"></script>
	<script src="{{ asset('js/jExcel/jquery.csv.min.js') }}"></script>
	<script src="{{ asset('js/jExcel/jquery.jcalendar.js') }}"></script>
	<script src="{{ asset('js/jExcel/jquery.jdropdown.js') }}"></script>
	<script src="{{ asset('js/jExcel/numeral.min.js') }}"></script>
	<script src="{{ asset('js/tktScripts.js') }}"></script>
@endsection