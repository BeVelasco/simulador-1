var estrategia = 0;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    ocultaEstrategias();
    pregunta();
});
var nombres = ['Alta', 'Ambiciosa', 'Baja', 'Selectiva'];

/**
 * Pregunta al usuario que tipo de Mercadotecnia utilizará.
 */
async function pregunta() {
    const {
        value: respuesta
    } = await Swal({
        type             : 'question',
        title            : 'Simulador',
        input            : 'select',
        inputOptions     : ['Alta', 'Ambiciosa', 'Baja', 'Selectiva'],
        inputPlaceholder : 'Seleccione una estrategia',
        showCancelButton : false,
        allowOutsideClick: false,
        inputValidator   : (value) => {
            return new Promise((resolve) => {
                if (value === '') {
                    resolve('Debe seleccionar un mes');
                } else {
                    resolve();
                }
            });
        }
    });
    ocultaEstrategias();
    estrategia = respuesta;
    switch (estrategia) {
        case '0':
            muestraPanel('alta');
            break;
        case '1':
            muestraPanel('ambiciosa');
            break;
        case '2':
            muestraPanel('baja');
            break;
        case '3':
            muestraPanel('selectiva');
            break;
        default:
            muestraAlerta('error', 'Error estrategia');
    }
}

/**
 * Oculta los paneles de todas las estrategias
 */
function ocultaEstrategias() {
    $(".aNav").each(function () {
        $(this).hide();
    });
    $(".divTab").each(function () {
        $(this).hide();
    });
}

/**
 * 
 * @param {nombre del tipo de mercadotecnia} nombre 
 */
function muestraPanel(nombre) {
    switch (nombre) {
        case 'alta':
            $("#aEstrategiaAlta").show();
            $("#estrategiaAlta").show();
            $("#txtPrecioAlta").focus();
            break;
        case 'ambiciosa':
            $("#aEstrategiaAmbi").show();
            $("#estrategiaAmbi").show();
            $("#txtPrecioAmbi").focus();
            break;
        case 'baja':
            $("#aEstrategiaBaja").show();
            $("#estrategiaBaja").show();
            $("#txtPrecioBaja").focus();
            break;
        case 'selectiva':
            $("#aEstrategiaSelect").show();
            $("#estrategiaSelect").show();
            $("#txtPrecioSelect").focus();
            break;
        default:
            muestraAlerta('error', 'Error tipo no existe.');
    }
}

/**
 * Valida y suma los datos introducidos por el usuario
 * 
 * @param {Input a validar} input 
 */
function suma(input) {
    var a = validarInput(input);
    if (a == 'valid') {
        $(input).parents('.form-line').removeClass('error');
        var suma = 0;
        switch (estrategia) {
            case '0':
                $(".inputAlta").each(function () {
                    suma += Number($(this).val());
                });
                $("#txtTotalAlta").val(suma);
                break;
            case '1':
                $(".input-Ambi").each(function () {
                    suma += Number($(this).val());
                });
                $("#txtTotalAmbi").val(suma);
                break;
            case '2':
                $(".inputBaja").each(function () {
                    suma += Number($(this).val());
                });
                $("#txtTotalBaja").val(suma);
                break;
            case '3':
                $(".inputSelect").each(function () {
                    suma += Number($(this).val());
                });
                $("#txtTotalSelect").val(suma);
                break;
            default:
                muestraAlerta('error', 'Error en la suma');
                break;
        }
    }
}

function guardaMerca() {
    var precio, canalesDistribucion, producto, promocion, relacionesPublicas, clientesInternos;
    switch (estrategia) {
        case '0':
            precio              = Number($("#txtPrecioAlta").val());
            canalesDistribucion = Number($("#txtCanalAlta").val());
            producto            = Number($("#txtProductoAlta").val());
            promocion           = Number($("#txtPromocionAlta").val());
            relacionesPublicas  = Number($("#txtRelacionesAlta").val());
            clientesInternos    = Number($("#txtClientesiAlta").val());
            break;
        case '1':
            precio              = Number($("#txtPrecioAmbi").val());
            canalesDistribucion = Number($("#txtCanalAmbi").val());
            promocion           = Number($("#txtPromocionAmbi").val());
            relacionesPublicas  = Number($("#txtRelacionesAmbi").val());
            clientesInternos    = Number($("#txtClientesiAmbi").val());
            break;
        case '2':
            precio    = Number($("#txtPrecioBaja").val());
            promocion = Number($("#txtPromocionBaja").val());
            break;
        case '3':
            precio              = Number($("#txtPrecioSelect").val());
            canalesDistribucion = Number($("#txtCanalSelect").val());
            promocion           = Number($("#txtPromocionSelect").val());
            relacionesPublicas  = Number($("#txtRelacionesSelect").val());
            clientesInternos    = Number($("#txtClientesiSelect").val());
            break;
        default:
            muestraAlerta('error', 'Error en el guardado');
            break;
    }
    $.ajax({
        url     : routes.guardarMercadotecnia,
        type    : 'POST',
        dataType: 'JSON',
        data    : {
            tipoMercadotecnia  : nombres[estrategia],
            precio             : precio,
            canalesDistribucion: canalesDistribucion,
            producto           : producto,
            promocion          : promocion,
            relacionesPublicas : relacionesPublicas,
            clientesInternos   : clientesInternos,
        },
        success: function (data) {
            muestraAlerta('success', data.message);
            setTimeout(function () {
                window.location.href = routes.inicioSimulador
            }, 1000);
        },
        error: function (data) {
            muestraAlerta('error', data.responseJSON.message);
        }
    });
}