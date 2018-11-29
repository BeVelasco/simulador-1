<div class="modal fade" id="addUnidaMedida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Agregar unidad de medida</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="formUnidadMedida">
					<fieldset>
						@csrf
						<div class="form-row">
							<div class="col">
								<label class="control-label" for="descripcionUM">Descripción</label>
								<input 
									id          = "descripcionUM"
									name        = "descripcionUM"
									placeholder = "Descripción"
									class       = "form-control input-md"
									required
									type        = "text"
								>
							</div>  
						</div>
					</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" name="cerraUM" id="cerrarUM">Cancelar</button>
				<button type="submit" class="btn btn-primary" onclick="addUnidadMedida()">Agregar unidad de medida</button>
			</div></form>
		</div>
	</div>
</div>