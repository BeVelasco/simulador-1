/* Funcion que muestra una alerta de error en el mensaje enviado */
function muestraAlerta(tipo, mensaje) {
    swal({
        type : tipo,
        title: $('meta[name="app-name"]').attr('content'),
        text : mensaje
    });
    return;
}