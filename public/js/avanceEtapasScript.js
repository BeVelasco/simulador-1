function obtenEtapasTerminadas(idProducto){
    $.ajax({
        url     : routes.obtenAvance,
        type    : 'POST',
        data    : { idProducto: idProducto },
        dataType: 'JSON',
        success : function (data) {
            var jsonData = {}, a = data, i= 0;
            a.forEach(opcion => {
                i != 0 ? jsonData[i] = opcion : null;
                i += 1;
            });
            (async function f() {
                const { value: etapa } = await Swal({
                    title            : 'Seleccione la etapa que desea ver:',
                    input            : 'select',
                    allowOutsideClick: false,
                    allowEscapeKey   : false,
                    inputOptions     : jsonData,
                    inputPlaceholder : 'Etapas concluídas',
                    showCancelButton : false,
                    inputValidator   : (value) => {
                        return new Promise((resolve) => {
                             resolve();
                        });
                    }
                });
                if (etapa) {
                    $.ajax({
                        url     : routes.mostrarEtapa,
                        type    : 'POST',
                        dataType: 'JSON',
                        data    : { etapa: etapa },
                        success : function (data1) {
                            switch (etapa)
                            {
                                case '1':
                                    muestraEtapaCosteo(data1);
                                break;
                                case '3':
                                    muestraEtapaInventario(data1);
                                break;
                                case '4':
                                    muestraEtapaMercadotecnia(data1);
                                break;
                                default:
                                    location.reload();
                                break;
                            }
                        },
                        error: function (data1) { muestraAlerta('error', data1.responseJSON.message); }
                    });
                }
            })()
        },
        error: function (dataError) {
            console.log(dataError);
            if (dataError.responseJSON.errors.idProducto){
                muestraAlerta('error', dataError.responseJSON.errors.idProducto[0]);
                return;
            }
        }
    });
}

function muestraEtapaCosteo(data1){
    $("#tableCosteo tr").remove(); 
    $('#costeoModal').modal('show');
    $("#spanModCosNomPro").html(data1.producto.idesc);
    $("#spanModCosPar").html(data1.producto.porcionpersona);
    $("#spanModCosUm").html(data1.producto.catum.idesc);
    var ingredientes = data1.ingredientes;
    var tableRef = document.getElementById('tableCosteo').getElementsByTagName('tbody')[0];
    ingredientes.forEach(option => {
        var newRow   = tableRef.insertRow(tableRef.rows.length);
        var newCell  = newRow.insertCell(0);
        var newCell2 = newRow.insertCell(1);
        var newText  = document.createTextNode(option[0]);
        var newText2 = document.createTextNode(option[5]);
        newCell.appendChild(newText);
        newCell2.appendChild(newText2);
    });
    $("#spanCosteoTotCosPri").html("$ " + data1.precioVenta.totalCostosPrimos);
    $("#spanCosteoCosUni").html(data1.precioVenta.costoUnitario);
    $("#spanCosteoPreVen").html("$ " + data1.precioVenta.precioVenta);
    $("#spanCosteoBenBruDes").html((100 - data1.costeo.PBBD) + " %");
    return;
}

function muestraEtapaInventario(data1){
    $('#inventarioModal').modal('show');
    $("#spanModInvNomPro").html(data1.producto.idesc);
    $("#spanInvCosPar").html(data1.producto.porcionpersona);
    $("#spanInvCosUm").html(data1.producto.catum.idesc);
    $("#spanInvVenAnu").html(data1.inventario.ventasAnuales);
    $("#spanInvVenProMen").html(formatear(Number(data1.inventario.venPromMen),2));
    $("#spanInvPorInvDes").html(formatear(Number(data1.inventario.porInvFinDes),2));
    $("#spanInvUniDesInvFin").html(formatear(Number(data1.inventario.uniInvFinDes),2));
    $("#spanInvCosDir").html(formatear(Number(data1.costoUnitario),2));
    $("#spanInvValIvFinDes").html(formatear(Number(data1.inventario.valInvFinDes),2));
}

function muestraEtapaMercadotecnia(data1){
    $('#mercadotecniaModal').modal('show');
    $('#spanTipMerca').html(data1.mercadotecnia.tipoMercadotecnia);
    $("#spanModMerNomPro").html(data1.producto.idesc);
    $("#spanMerCosPar").html(data1.producto.porcionpersona);
    $("#spanMerCosUm").html(data1.producto.catum.idesc);
    $("#spanMerPre").html(formatear(Number(data1.mercadotecnia.precio),2));
    $("#spanMerProm").html(formatear(Number(data1.mercadotecnia.promocion),2));
    $("#spanMerTot").html(formatear(Number(data1.mercadotecnia.total),2));
    var canales = formatear(Number(data1.mercadotecnia.canalesDistribucion), 2);
    if (canales == "0.00"){
        $("#trCanales").css('visibility','hidden');
    } else {
        $("#trCanales").css('visibility', 'visible');
        $("#spanMerCan").html(canales);
    }
    var producto = formatear(Number(data1.mercadotecnia.producto), 2);
    if (producto == "0.00") {
        $("#trProducto").css('visibility', 'hidden');
    } else {
        $("#trProducto").css('visibility', 'visible');
        $("#spanMerPro").html(producto);
    }
    var relaciones = formatear(Number(data1.mercadotecnia.relacionesPublicas), 2);
    if (relaciones == "0.00") {
        $("#trRelaciones").css('visibility', 'hidden');
    } else {
        $("#trRelaciones").css('visibility', 'visible');
        $("#spanMerRel").html(relaciones);
    }
    var clientes = formatear(Number(data1.mercadotecnia.relacionesPublicas), 2);
    if (clientes == "0.00") {
        $("#trClientes").css('visibility', 'hidden');
    } else {
        $("#trClientes").css('visibility', 'visible');
        $("#spanMerCli").html(clientes);
    }
}