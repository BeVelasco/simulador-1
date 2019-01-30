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
		<div class="header bg-green">
			<h2>
				Perfil de usuario
			</h2>
		</div>
		<div class="body">
            <div class="row">
				<div class="sm-12 align-right" id="divBtnSiguiente">
					<ul class="toolbar-form">
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
				<div class="col-sm-4 align-right">
					<label class="form-label">Nombre:</label>
				</div>
                <div  class="col-sm-6 align-right">
                    <div class="form-group form-float">
						<div class="form-line">
							<input 
								id          = "name"
								name        = "name"
								class       = "form-control input-md" 
								type        = "text"
							>
						</div>
					</div>
                </div>
            </div>
            <div class="row clearfix">
				<div class="col-sm-4 align-right">
					<label class="form-label">Correo electrónico:</label>
				</div>
                <div  class="col-sm-6 align-right">
                    <div class="form-group form-float">
						<div class="form-line">
							<input 
								id          = "email"
								name        = "email"
								class       = "form-control input-md" 
								type        = "text"
                                readonly
							>
						</div>
					</div>
                </div>
            </div>
            <div class="row clearfix">
				<div class="col-sm-4 align-right">
					<label class="form-label">Avatar:</label>
				</div>
                <div  class="col-sm-6 align-right">
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="caption">
                                    <p>
                                        <input name="avatar" type="radio" id="radio_1" value="user-1" checked="">
                                        <label for="radio_1"><img src="{{ asset('img\adminTemplate\user-1.png') }}" width="60" height="60"></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="caption">
                                    <p>
                                        <input name="avatar" type="radio" id="radio_2" value="user-2" checked="">
                                        <label for="radio_2"><img src="{{ asset('img\adminTemplate\user-2.png') }}" width="60" height="60"></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="caption">
                                    <p>
                                        <input name="avatar" type="radio" id="radio_3" value="user-3" checked="">
                                        <label for="radio_3"><img src="{{ asset('img\adminTemplate\user-3.png') }}" width="60" height="60"></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="caption">
                                    <p>
                                        <input name="avatar" type="radio" id="radio_4" value="user-4" checked="">
                                        <label for="radio_4"><img src="{{ asset('img\adminTemplate\user-4.png') }}" width="60" height="60"></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="caption">
                                    <p>
                                        <input name="avatar" type="radio" id="radio_5" value="user-5" checked="">
                                        <label for="radio_5"><img src="{{ asset('img\adminTemplate\user-5.png') }}" width="60" height="60"></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="caption">
                                    <p>
                                        <input name="avatar" type="radio" id="radio_6" value="user-6" checked="">
                                        <label for="radio_6"><img src="{{ asset('img\adminTemplate\user-6.png') }}" width="60" height="60"></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="caption">
                                    <p>
                                        <input name="avatar" type="radio" id="radio_7" value="user-7" checked="">
                                        <label for="radio_7"><img src="{{ asset('img\adminTemplate\user-7.png') }}" width="60" height="60"></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="caption">
                                    <p>
                                        <input name="avatar" type="radio" id="radio_8" value="user-8" checked="">
                                        <label for="radio_8"><img src="{{ asset('img\adminTemplate\user-8.png') }}" width="60" height="60"></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="caption">
                                    <p>
                                        <input name="avatar" type="radio" id="radio_9" value="user-9" checked="">
                                        <label for="radio_9"><img src="{{ asset('img\adminTemplate\user-9.png') }}" width="60" height="60"></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="caption">
                                    <p>
                                        <input name="avatar" type="radio" id="radio_10" value="user-10" checked="">
                                        <label for="radio_10"><img src="{{ asset('img\adminTemplate\user-10.png') }}" width="60" height="60"></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="caption">
                                    <p>
                                        <input name="avatar" type="radio" id="radio_11" value="user-11" checked="">
                                        <label for="radio_11"><img src="{{ asset('img\adminTemplate\user-11.png') }}" width="60" height="60"></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
	
@endsection

@section('scripts')
	<script src="{{ asset('js/perfilScripts.js') }}"></script>
@endsection