@php
	$variables = Session::all();
	$keys = array_keys($variables);
	var_dump($keys);
	$c = count($variables);
@endphp<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class=""></a>
			<a class="bars toggle"><span></span></a>
            <a class="navbar-brand" href="javascript:void(0);">SIMULADOR v1.0</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
			<div class="header-right">
				<ul class="nav navbar-nav ">
					<!-- Call Search -->
					<!--<li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>-->
					<!-- #END# Call Search -->
					<!-- Notifications -->
					<li class="dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
							<i class="material-icons">notifications</i>
							<span class="label-count">{{ $c }}</span>
						</a>
						<ul class="dropdown-menu">
							<li class="header">Variables en la sesión</li>
							<li class="body">
								<ul class="menu">
									@foreach ($variables as $item)
										<li>
											<div class="icon-circle bg-purple">
												<i class="material-icons">settings</i>
											</div>
											<div class="menu-info">
												<h4>{{ $keys[$loop->iteration-1] }}</h4>
												<p>
													<i class="material-icons">access_time</i> @php print_r($item); @endphp
												</p>
											</div>
										</li>
									@endforeach
									<li>
										<a href="javascript:void(0);">Fin</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<!-- #END# Notifications -->
					<!-- Tasks -->
					<li class="dropdown">
						<a href="/simulador/mensajero/mensajero" role="button">
							<i class="material-icons">mail</i>
							<span class="label-count">2</span>
						</a>
					</li>
				</ul>
				<!-- #END# Tasks -->
				<!--<li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>-->

				<span class="separator"></span>

				<div id="userbox" class="userbox">
					<a href="#" data-toggle="dropdown" aria-expanded="false">
						<figure class="profile-picture">
							<img id="imgAvatar" src="{{ asset('img/adminTemplate/'.Auth::user()->avatar.'.png') }}" class="img-circle" data-lock-picture="{{ asset('img/adminTemplate/usuario-male.png') }}">
						</figure>
						<div class="profile-info" data-lock-name="" data-lock-email="">
							<span class="name">{{ __('messages.hola') }} {{ Auth::user()->name}}</span>
							<span class="role">Usuario</span>
						</div>

						<i class="fa custom-caret"></i>
					</a>

					<div class="dropdown-menu">
						<ul class="list-unstyled">
							<li class="divider"></li>
							<li>
								<a role="menuitem" tabindex="-1" href="/usuario/editarInicio"><i class="fa fa-user"></i> Mi perfil</a>
							</li>
							<!--<li>
								<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Bloquear pantalla</a>
							</li>-->
							<li>
								<a
									class   = "dropdown-item"
									href    = "{{ route('logout') }}"
									onclick = "event.preventDefault();
									document.getElementById('logout-form').submit();"
								>
									<i class="fa fa-power-off"></i> {{ __('messages.salir') }}<!--messages.salir-->
								</a>
							</li>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</ul>
					</div>
				</div>
			</div>

        </div>
    </div>
</nav>
