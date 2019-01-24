@extends('base')

@section('assets')
    <style>
        .body{
            padding: 0px 30px 30px 240px !important;
        }
        
        .body h3 .titulo{
            margin: 30px;
            color:#777 !important;
            text-shadow: 1px 1px 1px #ccc !important;
        }
        
        
        .sidebar{
            width: 200px;
            background: linear-gradient(0deg,#3358f4,#1d8cf8);
            display: block;
            box-shadow: 0 0 45px 0 rgba(204, 203, 203, 0.6);;
            margin-top: 0px;
            margin-left: 20px;
            border-radius: 5px;
            transition: .5s cubic-bezier(.685,.0473,.346,1);
            padding:10px 10px 10px 10px;
        }
        
        .sidebar i{
            color: #fff;
            /*text-shadow: 1px 1px 1px #ccc;*/
            font-size: 1.5em;
        }
        .logo{
            position: relative;
            padding: 15px;
        }
        .logo:after{
            content: "";
            position: absolute;
            bottom: 0;
            right: 15px;
            height: 1px;
            width: calc(100% - 30px);
            background: hsla(0,0%,100%,.5);
        }
        .logo span{
            font-size: 18px;
            /* font-weight: bold; */
            color: #fff;
        }
        
        .sidebar ul li i, .sidebar ul li span{
            color: #fff9;
        }
        
        .sidebar .nav li.active>a i,.sidebar .nav li.active>a span {
            color: #fff;
        }
        
        
        .body .card {
            border-radius: 5px;
        }
        
        .body .header h2{
            color:#777 !important;
        }
        .card.news .body{
            padding: 20px !important;    
        }
        
        ul.noticia li{
            display: table-cell;
        }
        

        ul.noticia li img{
             border:solid 1px; 
             width:80px; 
             height:80px;
             border-radius: 5px;
             vertical-align: top;
        }
        i{
            margin-right: 0.5rem;
        }        
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="sidebar">
            <div class="sidebar-wrapper ps">
                <div class="logo">
                    <i class="fa fa-newspaper fa-2x"></i><span>Noticias</span>
                </div>
                <ul class="nav">
                    <li class="active">
                        <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">
                        <i class="fa fa-running"></i>
                        <span>Emprendedores</span></a>
                    </li>
                    <li class="">
                        <a class="nav-link" href="#/admin/icons"><i class="fa fa-chart-line"></i><span>Economía</span></a>
                    </li>
                    <li class="">
                        <a class="nav-link" href="#/admin/map"><i class="fa fa-hands"></i><span>Social</span></a>
                    </li>
                    <li class="">
                        <a class="nav-link" href="#/admin/notifications"><i class="fa fa-blog"></i><span>Blog</span></a>
                    </li>
                </ul>
                <br />
                <div class="logo">
                    <i class="fa fa-desktop fa-2x"></i><span>Ir a...</span>
                </div>
                <ul class="nav">
                    <li>
                        <a class="nav-link" href="{{route'home'}}">
                        <i class="fa fa-edit"></i>
                        <span>Simulador</span></a>
                    </li>
                </ul>
            </div>
        </div>
   	
		<div class="body">
			<div class="row clearfix">
                <h3>
                    <div class="titulo">
                        <i class="fa fa-running "></i>&nbsp;&nbsp;&nbsp;<span>Emprendedores</span>
                    </div>
                </h3>
                <div class="col-sm-12">
    				<div class="card news">
                        <div class="header bg-white">
                            <h2>
                                Nike lanza tenis 'inteligentes' que se atan y ajustan automáticamente
                            </h2>
                        </div>
                        <div class="body ">
                            <ul class="noticia">
                                <li>
                                    Que la tecnología forme parte de nuestros zapatos parece una cuestión de tiempo cuando vemos el empeño de algunos fabricantes por hacer esta prenda 'inteligente'. En Nike ven la solución a la adaptación perfecta en el ajuste y el atado, pero no los convencionales, sino los automáticos, y ahora presentan las nuevas Nike Adapt BB.
                                </li>
                                <li>
                                    <img src="/noticias/tenis.png"/>
                                </li>
                            </ul>
                            
    
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
    				<div class="card news">
                        <div class="header bg-white">
                            <h2>
                                Formulación
                            </h2>
                        </div>
                        <div class="body ">
                            <table id="tablaformulacion" class="table table-striped table-bordered dataTable no-footer" role="grid" style="width: 100%;"></table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
    				<div class="card news">
                        <div class="header bg-white">
                            <h2>
                                Ventas mensuales
                            </h2>
                        </div>
                        <div class="body ">
                            <table id="tablaventas" class="table table-striped table-bordered dataTable no-footer" role="grid" style="width: 100%;"></table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
    				<div class="card news">
                        <div class="header bg-white">
                            <h2>
                                Ventas mensuales
                            </h2>
                        </div>
                        <div class="body ">
                            <table id="tablaventas" class="table table-striped table-bordered dataTable no-footer" role="grid" style="width: 100%;"></table>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
	
@endsection


@section('scripts')
    <script src="{{ asset('js/noticiasScripts.js') }}"></script>
@endsection