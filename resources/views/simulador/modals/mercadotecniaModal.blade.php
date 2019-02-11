<div class="modal fade" id="mercadotecniaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <span id="spanModMerNomPro"></span> <br><span id=spanMerCosPar></span>&nbsp;<span id="spanMerCosUm"></span>
                                </h2>
                            </div>
                            <div class="body table-responsive">
                                <h2>Mercadotecnia <span id="spanTipMerca"></span></h2>
                                <table class="table" id="tableMercadotecnia">
                                    <tbody>
                                        <tr>
                                            <td>{{ __('messages.precio') }}</td>
                                            <td>$ <span id="spanMerPre"></span></td>
                                        </tr>
                                        <tr id="trCanales">
                                            <td >{{ __('messages.canales') }}</td>
                                            <td>$ <span id="spanMerCan"></span></td>
                                        </tr>
                                        <tr id="trProducto">
                                            <td>{{ __('messages.producto') }}</td>
                                            <td>$ <span id="spanMerPro"></span></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('messages.promocion') }}</td>
                                            <td>$ <span id="spanMerProm"></span></td>
                                        </tr>
                                        <tr id="trRelaciones">
                                            <td>{{ __('messages.relaciones') }}</td>
                                            <td>$ <span id="spanMerRel"></span></td>
                                        </tr>
                                        <tr id="trClientes">
                                            <td>{{ __('messages.ClientesI') }}</td>
                                            <td>$ <span id="spanMerCli"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>{{ __('messages.total') }}</b></td>
                                            <td><b>$ <span id="spanMerTot"></span></b></td>
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