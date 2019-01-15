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
					<button type="button" class="btn bg-blue waves-effect" onclick="javascript:regresar();">
						<i class="material-icons">arrow_back</i>
						<span>{{ __('messages.regresar') }}</span>
					</button>
					<br />
				</div>
			</div>
            <div class="row clearfix">
                <div class="sm-12">
                    <label class="form-label">Nómina anual: salarios y obligaciones</label>            
			        <div id="excelnomina"></div>
                </div>                     
            </div>
			<div class="row clearfix">
				<div class="col-sm-6 align-right">
					<label class="form-label">TOTAL:</label>
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
	<script src="{{ asset('js/nominaScripts.js') }}"></script>
@endsection