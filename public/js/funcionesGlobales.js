/* Funcion que muestra una alerta de error en el mensaje enviado */
function muestraAlerta(tipo, mensaje) {
    swal({
        type : tipo,
        title: $('meta[name="app-name"]').attr('content'),
        text : mensaje
    });
    return;
}

/* Funcion que redondea un número */
function redondear(num) {
    num = Intl.NumberFormat().format(Math.round(num));
    return num;
}

/* Función que pone el foco en el input enviado */
function setfocus(item) {
    setTimeout(function () {
        item.focus();
    }, 250);
}

/* Función que formatea un número con comas y los decimales especifícados */
function formatear(num, dec) {
    var estilo = {
        minimumFractionDigits: dec,
        maximumFractionDigits: dec
    };
    return num.toLocaleString('en', estilo);
}

/* Función que no permite inster la letra "e" en inputs numéricos */
function eliminaEInput(event) {
    return event.keyCode !== 69;
}