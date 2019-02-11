<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="row clearfix">
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="info-box bg-pink hover-expand-effect">
				<div class="icon">
					<i class="material-icons">local_offer</i>
				</div>
				<div class="content">
					<div class="text">
						<b><span id="noProd">{{ $noProductos }}</span></b>
						<span class="hidden" id="messages.productos"></span> 
							{{trans_choice('messages.productos', $noProductos)}} <br> {{trans_choice('messages.registrado', $noProductos)}}
						
					</div>
					<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="info-box bg-cyan hover-expand-effect">
				<div class="icon">
					<i class="material-icons">assignment</i>
				</div>
				<div class="content">
					<div class="text"> 
						<b><span id="numCatums">{{ $noCatum }}</span></b>
						{{trans_choice('messages.unidad', $noCatum)}} <br>
						{{__('messages.deMedida')}}
					</div>
					<div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"></div>
				</div>
			</div>
		</div>
	</div>
</div>