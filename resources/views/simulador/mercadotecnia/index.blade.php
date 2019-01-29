@extends('base')

@section('content')
    @php $idProducto = Session::get('prodSeleccionado'); @endphp
    <div class="container-fluid">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-green">
                    <div class="row">
                        <div class="col-lg-10">
                            <h2>{{ __('messages.merca') }}
                        <small>
                            {{ producto($idProducto,'idesc') }} para: {{ producto($idProducto,'porcionpersona') }} {{ catum(producto($idProducto,'idcatnum1'), 'idesc') }}
                        </small>
                    </h2>
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-warning waves-effect" onclick="pregunta()">Cambiar Mercadotecnia</button>
                        </div> 
                    </div>
                </div>
                <div class="body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                        <li role="presentation" class="active">
                            <a class="aNav" href="#estrategiaAlta" data-toggle="tab" aria-expanded="true" id="aEstrategiaAlta">{{ __('messages.estrategiaAlta') }}</a>
                        </li>
                        <li role="presentation" class="">
                            <a class="aNav" href="#estrategiaAmbi" aria-expanded="true" id="aEstrategiaAmbi">{{ __('messages.estrategiaAmbi') }}</a>
                        </li>
                        <li role="presentation" class="">
                            <a class="aNav" href="#estrategiaBaja" aria-expanded="true" id="aEstrategiaBaja">{{ __('messages.estrategiaBaja') }}</a>
                        </li>
                        <li role="presentation">
                            <a class="aNav" href="#estrateguaSelect" aria-expanded="true" id="aEstrategiaSelect">{{ __('messages.estrategiaSelect') }}</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="divTab tab-pane fade active in" id="estrategiaAlta">
                            @include('simulador.mercadotecnia.estrategiaAltaVista')
                        </div>
                        <div role="tabpanel" class="divTab tab-pane fade active in" id="estrategiaAmbi">
                            @include('simulador.mercadotecnia.estrategiaAmbiciosaVista')
                        </div>
                        <div role="tabpanel" class="divTab tab-pane fade active in" id="estrategiaBaja">
                             @include('simulador.mercadotecnia.estrategiaBajavista')
                        </div>
                        <div role="tabpanel" class="divTab tab-pane fade active in" id="estrategiaSelect">
                            @include('simulador.mercadotecnia.estrategiaSelectivavista')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
	<script src="{{ asset('js/simuladorScriptsMercadotecnia.js') }}"></script>
@endsection