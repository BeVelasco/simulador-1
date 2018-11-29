<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Agregar producto nuevo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form-producto">
					<fieldset>
						@csrf
						<div class="form-row">
							<div class="col-sm-4">
								<div class="form-group form-float">
									<div class="form-line">
										<input 
											id          = "descProd"
											name        = "descProd"
											class       = "form-control input-md" 
											type        = "text"
											required
										>
										<label class="form-label">Descripción</label>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group form-float">
									<div class="form-line">
										<input 
											id          = "porcion"
											name        = "porcion"
											class       = "form-control input-md" 
											type        = "number"
											min         = "0.01"
											step        = "0.01"
											max         = "999999.99"
											required
										>
										<label class="form-label">Para:</label>
									</div>
								</div>
							</div>
							<div class="col-sm-5">
								<select class="form-control" id="uMedida" name="uMedida" required>
									<option value="0" disabled selected>Unidad de medida</option>
									@foreach ($unidadMedidas as $unidadMedida)
										<option value="{{ $unidadMedida -> id }}">{{ $unidadMedida -> idesc }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</fieldset>
				</form>
				<div class="row" style="padding-top: 10px;">
					<div class="col-lg-4 col-md-4 offset-8">
						<div class="form-row">

						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
					<div class="col-sm-2">
						<button 
							class         = "btn bg-blue waves-effect btn-xs"
							type          = "button"
							data-toggle   = "modal"
							data-target   = "#addUnidaMedida"
							data-backdrop = "static"
							data-keyboard = "false"><small>Agregar <br>unidad de medida</small>
						</button>
					</div>
					<div class="col-sm-4"></div>
					<div class="col-sm-6">
						<button type="button" class="btn btn-danger bg-blue waves-effect btn-lg" data-dismiss="modal" id="cerrarProd" name="cerrarProd">Cancelar</button>
						<button type="submit" class="btn btn-success waves-effect btn-lg" onclick="addProducto()">Agregar producto</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>