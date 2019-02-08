@extends('base')

@section('assets')
	<link href="{{ asset('css/jExcel/jquery.jcalendar.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jdropdown.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.green.css') }}" rel="stylesheet">
    
    <style>
        .jexcel > thead > tr, .jexcel > tbody > tr {
            display: table-row
        }
        
    </style>
@endsection

@section('content')
	<div class="card">

		<div class="body">
            <div class="row">
				<div class="sm-12 align-right" id="divBtnSiguiente">
					<ul class="toolbar-form">
                        <li>
            				    <input type="checkbox" id="chkGuardarvacias" class="filled-in"  />
                                <label for="chkGuardarvacias">Guardar con celdas vacías</label>
            			</li>
                        <li>
            				<button id="btnguardar" type="button" class="btn bg-blue waves-effect" onclick="javascript:Guardar();">
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
            
            <div class="row">
                &nbsp;
            </div>
            <!-- Nav tabs -->
			<ul class="nav nav-tabs tab-nav-right" role="tablist">
				<li role="presentation" class="active">
					<a href="#situacioninicial" data-toggle="tab">Situación Inicial</a>
				</li>
				<li role="presentation" >
					<a href="#ventas" data-toggle="tab">Ventas</a>
				</li>
				<li role="presentation" >
					<a href="#costos" data-toggle="tab">Costo de ventas e inventarios</a>
				</li>
				<li role="presentation" >
					<a href="#gastos" data-toggle="tab">Gastos operativos</a>
				</li>
				<li role="presentation" >
					<a href="#tasadescuento" data-toggle="tab">Tasa de descuento</a>
				</li>
                <li role="presentation" >
					<a href="#prestamos" data-toggle="tab">Financiamiento y prestamos</a>
				</li>
			</ul>
            <!-- Tab panes -->
			<div class="tab-content">
				<!-- Tab Poblacion Obejtivo -->
				<div role="tabpanel" class="tab-pane fade active in" id="situacioninicial">
					<div id="excelsituacion"></div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="ventas">
					<div id="excelventas"></div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="costos">
                    <div class="col-sm-12 align-center">
                        <label class="form-label">PORCENTAJE DE COSTO DE VENTAS:</label>
                    </div>
                    <div class="row clearfix"></div>
					<div class="col-sm-4 align-right">
    					<label class="form-label">AÑO 1:</label>
    				</div>
                    <div  class="col-sm-1 align-right">
                        <div class="form-group form-float">
    						<div class="form-line">
    							<input 
    								id          = "anio1costos"
    								name        = "anio1costos"
    								class       = "form-control input-md" 
    								type        = "text"
                                    readonly
    							>
    						</div>
    					</div>
                    </div>
                    
                    <div class="row clearfix"></div>
					<div class="col-sm-4 align-right">
    					<label class="form-label">AÑO 2:</label>
    				</div>
                    <div  class="col-sm-1 align-right">
                        <div class="form-group form-float">
    						<div class="form-line">
    							<input 
    								id          = "anio2costos"
    								name        = "anio2costos"
    								class       = "form-control input-md" 
    								type        = "text"
                                    readonly
    							>
    						</div>
    					</div>
                    </div>
                    
                    <div class="row clearfix"></div>
					<div class="col-sm-4 align-right">
    					<label class="form-label">AÑO 3:</label>
    				</div>
                    <div  class="col-sm-1 align-right">
                        <div class="form-group form-float">
    						<div class="form-line">
    							<input 
    								id          = "anio3costos"
    								name        = "anio3costos"
    								class       = "form-control input-md" 
    								type        = "text"
                                    readonly
    							>
    						</div>
    					</div>
                    </div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="gastos">
                    <div class="row clearfix"></div>
                    <div class="col-sm-4 align-right">
    					<label class="form-label">AÑO 1:</label>
    				</div>
                    <div class="col-sm-4 align-right">
    					<label class="form-label">AÑO 2:</label>
    				</div>
                    
                    <div class="row clearfix"></div>
                    <div class="col-sm-3 align-center">
                        <label class="form-label">Porcentaje de incremento en gastos operativos:</label>
                    </div>
                    <form id="porcentajeGastos" class="formpage">
                        <div  class="col-sm-1 align-right">
                            <div class="form-group form-float">
        						<div class="form-line">
        							<input 
        								id          = "anio1gastos"
        								name        = "anio1gastos"
        								class       = "form-control input-md" 
        								type        = "number"
    									min         = "0.00"
    									step        = "0.01"
    									max         = "100.00"
        							>
        						</div>
        					</div>
                        </div>
                        <div class="col-sm-3 align-center"></div>
    					
                        <div  class="col-sm-1 align-right">
                            <div class="form-group form-float">
        						<div class="form-line">
        							<input 
        								id          = "anio2gastos"
        								name        = "anio2gastos"
        								class       = "form-control input-md" 
        								type        = "number"
                                        min         = "0"
    									step        = "0.01"
    									max         = "100.00"
        							>
        						</div>
        					</div>
                        </div>
                    </form>
                    <div class="row clearfix"></div>
                        <div id="excelgastos"></div>
                    
                    <div class="row clearfix"></div>    
                    <div class="row clearfix"></div>
    				<div class="col-sm-6 align-right">
    					<label class="form-label">TOTAL DE GASTOS:</label>
    				</div>
                    <div  class="col-sm-2 align-left">
                        <div class="form-group form-float">
    						<div class="form-line">
    							<input 
    								id          = "totalgastos"
    								name        = "totalgastos"
    								class       = "form-control input-md" 
    								type        = "text"
                                    readonly
    							>
    						</div>
    					</div>
                    </div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="tasadescuento">
					<div class="col-sm-4 align-right">
    					<label class="form-label">Tasa líder, CETE a 28 días:</label>
    				</div>
                    <div  class="col-sm-1 align-right">
                        <div class="form-group form-float">
    						<div class="form-line">
    							<input 
    								id          = "tasalider"
    								name        = "tasalider"
    								class       = "form-control input-md" 
    								type        = "number"
                                    min         = "0"
									step        = "0.01"
									max         = "100.00"
                                    
    							>
    						</div>
    					</div>
                    </div>
                    
                    <div class="row clearfix"></div>
					<div class="col-sm-4 align-right">
    					<label class="form-label">Prima al riesgo deseada (Excedente sobre la tasa libre de Riesgo)</label>
    				</div>
                    <div  class="col-sm-1 align-right">
                        <div class="form-group form-float">
    						<div class="form-line">
    							<input 
    								id          = "primariesgo"
    								name        = "primariesgo"
    								class       = "form-control input-md" 
    								type        = "number"
                                    min         = "0"
									step        = "0.01"
									max         = "100.00"
                                    
    							>
    						</div>
    					</div>
                    </div>
                    
                    <div class="row clearfix"></div>
					<div class="col-sm-4 align-right">
    					<label class="form-label">Riesgo país S&amp;P (EMBI - México):</label>
    				</div>
                    <div  class="col-sm-1 align-right">
                        <div class="form-group form-float">
    						<div class="form-line">
    							<input 
    								id          = "riesgopais"
    								name        = "riesgopais"
    								class       = "form-control input-md" 
    								type        = "number"
                                    min         = "0"
									step        = "0.01"
									max         = "100.00"
                                    
    							>
    						</div>
    					</div>
                    </div>
				</div>
                <div role="tabpanel" class="tab-pane fade" id="prestamos">
					<div class="col-sm-4 align-right">
    					<label class="form-label">Tasa de interés, prestamo a largo plazo:</label>
    				</div>
                    <div  class="col-sm-1 align-right">
                        <div class="form-group form-float">
    						<div class="form-line">
    							<input 
    								id          = "tasalargoplazo"
    								name        = "tasalargoplazo"
    								class       = "form-control input-md" 
    								type        = "number"
                                    min         = "0"
									step        = "0.01"
									max         = "100.00"
                                    
    							>
    						</div>
    					</div>
                    </div>
                    
                    <div class="row clearfix"></div>
					<div class="col-sm-4 align-right">
    					<label class="form-label">Tasa de interés si déficit de efectivo a corto plazo:  </label>
    				</div>
                    <div  class="col-sm-1 align-right">
                        <div class="form-group form-float">
    						<div class="form-line">
    							<input 
    								id          = "tasacortoplazo"
    								name        = "tasacortoplazo"
    								class       = "form-control input-md" 
    								type        = "number"
                                    min         = "0"
									step        = "0.01"
									max         = "100.00"
                                    
    							>
    						</div>
    					</div>
                    </div>
                    
                    <div class="row clearfix"></div>
					<div class="col-sm-4 align-right">
    					<label class="form-label">Interés a favor, si excedente de efectivo a corto plazo:  </label>
    				</div>
                    <div  class="col-sm-1 align-right">
                        <div class="form-group form-float">
    						<div class="form-line">
    							<input 
    								id          = "interesexcedente"
    								name        = "interesexcedente"
    								class       = "form-control input-md" 
    								type        = "number"
                                    min         = "0"
									step        = "0.01"
									max         = "100.00"
                                    
    							>
    						</div>
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
    
	<script src="{{ asset('js/situacioninicialScripts.js') }}"></script>
@endsection