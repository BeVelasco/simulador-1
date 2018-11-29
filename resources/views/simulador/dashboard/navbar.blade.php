<nav class="navbar">
	<div class="container-fluid">
		<div class="navbar-header">
			<a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
			<a href="javascript:void(0);" class="bars"></a>
			<a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Simulador') }}</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<!-- Notifications -->
				<li class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
						<i class="material-icons">notifications</i>
						<span class="label-count">1</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">Notificaciones</li>
						<li class="body">
							<ul class="menu">
								<li>
									<a href="javascript:void(0);">
										<div class="icon-circle bg-light-green">
											<i class="material-icons">person_add</i>
										</div>
										<div class="menu-info">
											<h4>12 nuevos miembros.</h4>
											<p>
												<i class="material-icons">access_time</i> Hace 14 min.
											</p>
										</div>
									</a>
								</li>
							</ul>
						</li>
						<li class="footer">
							<a href="javascript:void(0);">Ver Todas Las Notificaciones</a>
						</li>
					</ul>
				</li>
				<!-- #END# Notifications -->
				<!-- Tasks -->
				<li class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
						<i class="material-icons">flag</i>
						<span class="label-count">1</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">Tareas</li>
						<li class="body">
							<ul class="menu tasks">
								<li>
									<a href="javascript:void(0);">
										<h4>
											Ponerl lo que se llevaba 
											<small>32%</small>
										</h4>
										<div class="progress">
											<div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">
											</div>
										</div>
									</a>
								</li>
							</ul>
						</li>
						<li class="footer">
							<a href="javascript:void(0);">Ver Todas Las Tareas</a>
						</li>
					</ul>
				</li>
				<!-- #END# Tasks -->
				<li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
			</ul>
		</div>
	</div>
</nav>