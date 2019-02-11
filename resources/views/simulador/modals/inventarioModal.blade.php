<div class="modal fade" id="inventarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ __('messages.etapaInventario') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-1 col-md-1"></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <span id="spanModInvNomPro"></span> <br><span id=spanInvCosPar></span>&nbsp;<span id="spanInvCosUm"></span>
                                </h2>
                            </div>
                            <div class="body table-responsive">
                                <table class="table" id="tableInventario">
                                    <tbody>
                                        <tr>
                                            <td>{{ __('messages.ventasAnuales') }}</td>
                                            <td><span id="spanInvVenAnu"></span> unidades.</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('messages.ventasPromMensual') }}</td>
                                            <td><span id="spanInvVenProMen"></span> unidades.</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('messages.porcInvDeseado2') }}</td>
                                            <td><span id="spanInvPorInvDes"></span> %</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('messages.uniDesInvFin') }}</td>
                                            <td><span id="spanInvUniDesInvFin"></span> unidades.</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('messages.costoDirecto') }}</td>
                                            <td>$ <span id="spanInvCosDir"></span></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('messages.valInvFinDes') }}</td>
                                            <td>$ <span id="spanInvValIvFinDes"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
					<div class="col-sm-2">
						
					</div>
					<div class="col-sm-4"></div>
					<div class="col-sm-6">
                        <button
                            type         = "button"
                            class        = "btn btn-danger bg-blue waves-effect btn-lg"
                            data-dismiss = "modal"
                            id           = "cerrarProd"
                            name         = "cerrarProd">{{ __('messages.etapaCerrar') }}
                        </button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>