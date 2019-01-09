<div class="modal fade" id="addMensaje" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Agregar mensaje</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form-mensaje">
					<fieldset>
						@csrf
                        <div class="row clearfix">
							<div class="col-sm-6">
                                <label class="form-label">Para:</label>
								<select class="form-control" id="id_usuario_destino" name="id_usuario_destino" required>
									<option value="0" disabled selected>Para</option>
                                    <option value="1" >Asesor legal</option>
                                    <option value="2" >Asesor contable</option>
								</select>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-sm-12">
                                <label class="form-label">Asunto</label>
								<div class="form-group form-float">
									<div class="form-line">
										<input 
											id          = "asunto"
											name        = "asunto"
											class       = "form-control input-md" 
											type        = "text"
											required
										>
									</div>
								</div>
							</div>
                        </div>
                        <div class="row clearfix">
							<div class="col-sm-12">
                                <label class="form-label">Mensaje</label>
								<div class="form-group form-float">
									<div class="form-line">
										<textarea 
											id          = "cuerpo"
											name        = "cuerpo"
											class       = "form-control input-md" 
											required
										></textarea>
									</div>
								</div>
							</div>
                        </div>
                        
					</fieldset>
				</form>
			</div>
            <div class="modal-footer">
					<div class="col-sm-6"></div>
					<div class="col-sm-6">
						<button type="button" class="btn btn-danger bg-blue waves-effect btn-lg" data-dismiss="modal" id="cerrarmensaje" name="cerrarmensaje">Cancelar</button>
						<button type="submit" class="btn btn-success waves-effect btn-lg" onclick="addMensaje()">Enviar mensaje</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>