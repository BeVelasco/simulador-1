@extends('base')

@section('assets')
	<link href="{{ asset('css/jExcel/jquery.jcalendar.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jdropdown.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.green.css') }}" rel="stylesheet">
    
    <link href="{{ asset('css/reportes/perdidasganancias.css') }}" rel="stylesheet">
    <style>
        .jexcel > thead > tr, .jexcel > tbody > tr {
            display: table-row
        }
    </style>
@endsection

@section('content')
	<div class="card">

		<div class="body">
            <div class="row clearfix">
                <div class="sm-12">
                    <label class="form-label">Estado de pérdidas y ganancias</label>            
			        
                </div>                     
            </div>
			<div class="row clearfix">
				<div id="tab-content" style="height: 34em;" class="tab-content">
                </div>
            </div>
            
            
		</div>
	</div>
	
@endsection

@section('scripts')
	<script src="{{ asset('js/jExcel/numeral.min.js') }}"></script>
	<script src="{{ asset('js/reportes/perdidasgananciasScripts.js') }}"></script>
@endsection