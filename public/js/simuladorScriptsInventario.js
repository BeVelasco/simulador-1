$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    }
});
var Inventario = {
    "uniVenAnu"   : $("#spanUniVenAnu").text(),
    "venPromMen"  : 0,
    "porFinDes"   : 0,
    "uniDesInvFin": 0,
    "costoDirecto": 0,
    "valInvFinDes": 0,
};
$(document).ready(function () {
    $("#spanUniVenAnu").text(formatear(Number($("#spanUniVenAnu").text()), 0));
    Inventario.venPromMen = Number($("#spanVenProMen").text());
    $("#spanVenProMen").text(formatear(Inventario.venPromMen, 0));
    Inventario.costoDirecto = Number($("#spanCostoDirecto").text());
});
/* Función que no permite inster la letra "e" en inputs numéricos */
function eliminaEInput(event) { return event.keyCode !== 69; }

/* Función que calcula la valuación de inventario final deaseado */
function calcularInventario(a) {
    if ((a.value > 100) || (a.value < 0)) a.value = a.value.slice(0, -1);
    Inventario.porFinDes = Number($("#txtPorFinDes").val());
    /* Compruebo que los valores sean numéricos */
    if (!Inventario.uniVenAnu || 0)  {
        muestraAlertaError('Datos inesperados, actualice la página.');
    } else {
        Inventario.venPromMen   = Inventario.uniVenAnu/12;
        Inventario.uniDesInvFin = (Inventario.venPromMen * Inventario.porFinDes) / 100;
        Inventario.valInvFinDes = Inventario.costoDirecto * Inventario.uniDesInvFin;
        $("#spanVenProMen").html(formatear(Inventario.venPromMen,0));
        $("#spanUniDesInvFin").html(formatear(Inventario.uniDesInvFin, 2));
        $("#spanValInvFinDes").html(formatear(Inventario.valInvFinDes, 2));
    }
}

/* Guardo el inventario */
function guardarInventario(){
    $.ajax({
        url     : '/simulador/guardarInventario',
        type    : 'POST',
        dataType: 'JSON',
        data    : {
            uniVenAnu   : Inventario.uniVenAnu,
            venPromMen  : Inventario.venPromMen,
            porFinDes   : Inventario.porFinDes,
            uniDesInvFin: Inventario.uniDesInvFin,
            valInvFinDes: Inventario.valInvFinDes
        },
        success: function (data) {
            document.location.replace(data.ruta);
            return;
        },
        error: function(data) {
            muestraAlertaError(data.message);
        }
    });
}

/* Funcion que muestra una alerta de error en el mensaje enviado */
function muestraAlertaError(a) { swal({ type: 'error', title: 'Simulador', text: a }); }
/* Funcion que redondea un número */
function redondear(num) { num = Intl.NumberFormat().format(Math.round(num)); return num; }
/* Función que formatea un número con comas y los decimales especifícados */
function formatear(num, dec) {
    var estilo = { minimumFractionDigits: dec, maximumFractionDigits: dec };
    return num.toLocaleString('en', estilo);
}

/**=========================================================================
 * Regresar al menu de productos
 * =========================================================================
 */
function regresar(){ window.location.href = "/home"; }