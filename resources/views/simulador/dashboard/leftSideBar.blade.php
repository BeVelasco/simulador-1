<aside id="leftsidebar" class="sidebar">
	<!-- User Info -->
	<div class="user-info">
		<div class="image">
			<img src="img/adminTemplate/user.png" width="48" height="48" alt="User" />
		</div>
		<div class="info-container">
			<div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user() -> name }}</div>
			<div class="email">{{ Auth::user() -> email }}</div>
			<div class="btn-group user-helper-dropdown">
				<i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
				<ul class="dropdown-menu pull-right">
					<li><a href="javascript:void(0);"><i class="material-icons">person</i>{{ __('messages.perfil') }}</a></li><!--messages.perfil-->
					<li role="separator" class="divider"></li>
					<li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Alguna opción</a></li>
					<li role="separator" class="divider"></li>
					<li>
						<a
							class   = "dropdown-item"
							href    = "{{ route('logout') }}"
							onclick = "event.preventDefault();
							document.getElementById('logout-form').submit();"
						>
							<i class="material-icons">input</i>{{ __('messages.salir') }}<!--messages.salir-->
						</a>
					</li>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</ul>
			</div>
		</div>
	</div>
	<!-- #User Info -->
	<!-- Menu -->
	<div class="menu">
		<ul class="list">
			<li class="header" style="text-transform: uppercase !important;">{{ __('messages.navPrincipal') }}</li><!--messages.navPrincipal-->
			<li class="active">
				<a href="{{ url('/home')}}">
					<i class="material-icons">home</i>
					<span>{{ __('messages.inicio') }}</span><!--messages.inicio-->
				</a>
			</li>
			<li>
				<a href="javascript:void(0);" class="menu-toggle">
					<i class="material-icons">widgets</i>
					<span>Algo</span>
				</a>
				<ul class="ml-menu">
					<li>
						<a href="javascript:void(0);" class="menu-toggle">
							<span>Cards</span>
						</a>
						<ul class="ml-menu">
							<li>
								<a href="pages/widgets/cards/basic.html">Basic</a>
							</li>
							<li>
								<a href="pages/widgets/cards/colored.html">Colored</a>
							</li>
							<li>
								<a href="pages/widgets/cards/no-header.html">No Header</a>
							</li>
						</ul>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<!-- #Menu -->
	<!-- Footer -->
	<div class="legal">
		<div class="version">
			<a href="javascript:void(0);">{{ config('app.name') }}</a> - <b>Version: </b> {{ config('app.version') }}
		</div>
		<div class="copyright">
			&copy; {{ __('messages.iic') }} 2018<br><!--messages.iic-->

		</div>
	</div>
	<!-- #Footer -->
</aside>