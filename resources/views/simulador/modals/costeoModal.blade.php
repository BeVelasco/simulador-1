<div class="modal fade" id="costeoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ __('messages.etapaCosteo') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-lg-1 col-md-1"></div>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <span id="spanModCosNomPro"></span> <br><span id=spanModCosPar></span>&nbsp;<span id="spanModCosUm"></span>
                                </h2>
                            </div>
                            <div class="body table-responsive">
                                <table class="table" id="tableCosteo">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.ingrediente') }}</th>
                                            <th>{{ __('messages.costoIngrediente') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="row">
                    <div class="col-lg-2 col-md-2"></div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="body table-responsive">
                                <table class="table" id="tableCosteo2">
                                    <tbody>
                                        <tr>
                                            <td>{{ __('messages.sumaCP') }}</td>
                                            <td><span id="spanCosteoTotCosPri"></span></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('messages.costoUnitario') }}</td>
                                            <td><span id="spanCosteoCosUni"></span></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('messages.precioVenta') }}</td>
                                            <td><span id="spanCosteoPreVen"></span></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('messages.bbd') }}</td>
                                            <td><span id="spanCosteoBenBruDes"></span></td>
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