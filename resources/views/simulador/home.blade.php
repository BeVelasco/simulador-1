@extends('simulador.base')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">Seleccione un producto</div>
					<div class="card-body text-center col-md-12">
						<div class="row">
							<div class="col-md-8">
								<form>
									{{ csrf_field() }}
									<div class="form-group">
										<select class="form-control" id="sel1">
											<option value="-1" selected disabled>Seleccione un producto</option>
											@foreach($productos as $producto)
												<option>
													{{$producto -> nombreProducto}} - {{$producto -> porcion}}
												</option>
											@endforeach
										</select>
									</div>
								</form>
							</div>
							<div class="col-md-2">
								<button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
									Crear producto nuevo
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Crear nuevo producto</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="/crearProducto" method="post">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-6">
							<label for="nombreProducto">Nombre del Producto:</label>
							<div class="form-group">
								<input
									type        ="text"
									class       ="form-control" 
									id          ="nombreProducto"
									placeholder ="Nombre del producto"
									required
								>
							</div>
						</div>
						<div class="col-md-6">
							<label for="porcion">Porciòn:</label>
							<div class="form-group">
								<input
									type        ="number"
									min         = 1
									step        = 1
									class       ="form-control" 
									id          ="porcion"
									placeholder ="52"
									required
								>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label for="unidadMedida">Unidad de medida:</label>
							<div class="form-group">
								<select class="form-control" id="unidadMedida" required>
									<option value="-1" selected disabled >Seleccione</option>
									@foreach($unidadesMedida as $unidadMedida)
										<option value = "{{$unidadMedida -> id}}">
											{{$unidadMedida -> descripcion}}
										</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<label >&nbsp;</label>
							<div class="form-group">
								<button class="btn btn-info" disabled>Crear Producto</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>