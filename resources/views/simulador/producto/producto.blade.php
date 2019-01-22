@extends('base')

@section('assets')
@php $idProducto = Session::get('prodSeleccionado'); @endphp
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
				{{ producto($idProducto,'idesc') }}
				<small>
					{{ producto($idProducto,'idesc') }} para: {{ producto($idProducto,'porcionpersona') }} {{ catum(producto($idProducto,'idcatnum1'),'idesc') }}
				</small>
			</h2>
		</div>
		<div class="body">
            <div class="row">
				<div class="sm-8 align-right" id="divBtnSiguiente">
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
            <div class="row">
                &nbsp;
            </div>
            <div class="row">
                <div class="sm-12">            
			         <div id="mytable"></div>
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
	<script src="{{ asset('js/productoScripts.js') }}"></script>
@endsection