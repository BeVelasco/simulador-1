<div class="modal fade" id="addProyecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Nombrar proyecto</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form-proyecto">
					<fieldset>
						@csrf
						<div class="form-row">
							<div class="col-sm-12">
								<div class="form-group form-float">
									<div class="form-line">
										<input 
											id          = "descProyecto"
											name        = "descProyecto"
											class       = "form-control input-md" 
											type        = "text"
											required
										>
										<label class="form-label">Nombre del proyecto</label>
									</div>
								</div>
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
					<div class="col-sm-6"></div>
					<div class="col-sm-6">
						<button type="button" class="btn btn-danger bg-blue waves-effect btn-lg" data-dismiss="modal" id="cerrarProyecto" name="cerrarProyecto">Cancelar</button>
						<button type="submit" class="btn btn-success waves-effect btn-lg" onclick="addProyecto()">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>