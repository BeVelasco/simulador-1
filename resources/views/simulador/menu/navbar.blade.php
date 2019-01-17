<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class=""></a>
			<a class="bars toggle"><span></span></a>
            <a class="navbar-brand" href="#">SIMULADOR v1.0</a>
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
							<span class="label-count">7</span>
						</a>
						<ul class="dropdown-menu">
							<li class="header">NOTIFICATIONS</li>
							<li class="body">
								<ul class="menu">
									<li>
										<a href="javascript:void(0);">
											<div class="icon-circle bg-light-green">
												<i class="material-icons">person_add</i>
											</div>
											<div class="menu-info">
												<h4>12 new members joined</h4>
												<p>
													<i class="material-icons">access_time</i> 14 mins ago
												</p>
											</div>
										</a>
									</li>
									<li>
										<a href="javascript:void(0);">
											<div class="icon-circle bg-cyan">
												<i class="material-icons">add_shopping_cart</i>
											</div>
											<div class="menu-info">
												<h4>4 sales made</h4>
												<p>
													<i class="material-icons">access_time</i> 22 mins ago
												</p>
											</div>
										</a>
									</li>
									<li>
										<a href="javascript:void(0);">
											<div class="icon-circle bg-red">
												<i class="material-icons">delete_forever</i>
											</div>
											<div class="menu-info">
												<h4><b>Nancy Doe</b> deleted account</h4>
												<p>
													<i class="material-icons">access_time</i> 3 hours ago
												</p>
											</div>
										</a>
									</li>
									<li>
										<a href="javascript:void(0);">
											<div class="icon-circle bg-orange">
												<i class="material-icons">mode_edit</i>
											</div>
											<div class="menu-info">
												<h4><b>Nancy</b> changed name</h4>
												<p>
													<i class="material-icons">access_time</i> 2 hours ago
												</p>
											</div>
										</a>
									</li>
									<li>
										<a href="javascript:void(0);">
											<div class="icon-circle bg-blue-grey">
												<i class="material-icons">comment</i>
											</div>
											<div class="menu-info">
												<h4><b>John</b> commented your post</h4>
												<p>
													<i class="material-icons">access_time</i> 4 hours ago
												</p>
											</div>
										</a>
									</li>
									<li>
										<a href="javascript:void(0);">
											<div class="icon-circle bg-light-green">
												<i class="material-icons">cached</i>
											</div>
											<div class="menu-info">
												<h4><b>John</b> updated status</h4>
												<p>
													<i class="material-icons">access_time</i> 3 hours ago
												</p>
											</div>
										</a>
									</li>
									<li>
										<a href="javascript:void(0);">
											<div class="icon-circle bg-purple">
												<i class="material-icons">settings</i>
											</div>
											<div class="menu-info">
												<h4>Settings updated</h4>
												<p>
													<i class="material-icons">access_time</i> Yesterday
												</p>
											</div>
										</a>
									</li>
								</ul>
							</li>
							<li class="footer">
								<a href="javascript:void(0);">View All Notifications</a>
							</li>
						</ul>
					</li>
					<!-- #END# Notifications -->
					<!-- Tasks -->
					<li class="dropdown">
						<a href="javascript:void(0);" role="button">
							<i class="material-icons">mail</i>
							<span class="label-count">9</span>
						</a>
					</li>
				</ul>
				<!-- #END# Tasks -->
				<!--<li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>-->
				
				<span class="separator"></span>
				
				<div id="userbox" class="userbox">
					<a href="#" data-toggle="dropdown" aria-expanded="false">
						<figure class="profile-picture">
							<img src="{{ asset('img/logged-man.jpg') }}" alt="Joseph Doe" class="img-circle" data-lock-picture="{{ asset('img/logged-man.jpg') }}">
						</figure>
						<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
							<span class="name">{{ __('messages.hola') }} {{ Auth::user()->name}}</span>
							<span class="role">Usuario</span>
						</div>
		
						<i class="fa custom-caret"></i>
					</a>
		
					<div class="dropdown-menu">
						<ul class="list-unstyled">
							<li class="divider"></li>
							<li>
								<a role="menuitem" tabindex="-1" href="pages-user-profile.html"><i class="fa fa-user"></i> My Profile</a>
							</li>
							<li>
								<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Lock Screen</a>
							</li>
							<li>
								<a role="menuitem" tabindex="-1" href="pages-signin.html"><i class="fa fa-power-off"></i> Logout</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
            
        </div>
    </div>
</nav>