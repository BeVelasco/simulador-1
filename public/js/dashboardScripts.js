/*
=========================================================
* Scripts para Dashboard de Simulador - v0.1
=========================================================
* Autor: Emmanuel Hernández Díaz
* Copyright 2018
* Integra Ideas Consultores
=========================================================
*/
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
/**
 * Funcion para agregar unidad de medida
 */
function addUnidadMedida() {
	if($("#formUnidadMedida")[0].checkValidity()) {
		$.ajax({
			url     : 'addUnidadMedida',
			type    : 'POST',
			data    : { descripcion :$("#descripcionUM").val() },
			dataType: 'JSON',
			success : function (data) { 
				swal({
					type : 'success',
					title: data.message,
					onClose: () => {
						$("#cerrarUM").click();
						$("#descripcionUM").val('');
						document.getElementById("numCatums").innerHTML = data.val;
						/* Se agrega al select el nuevo produco*/
						$("#uMedida")
							.append('<option value="'+data.val+'">'+data.option+'</option>')
							.selectpicker('refresh');
					}
				});
			},
			error: function(error)
			{	
				if (error.responseJSON.errors.descripcion){
					muestraAlerta('error', error.responseJSON.errors.descripcion[0]
					.toString()
					.replace("%um%", $("#descripcionUM").val()));
				}
			}
		}); 
	} else { $("#formUnidadMedida")[0].reportValidity(); }
}

/**
 * Funcion para agregar un producto nuevo
 */
function addProducto() {
	if($("#form-producto")[0].checkValidity()) {
		$.ajax({
			url : 'addProducto',
			type: 'POST',
			data: {
				descripcion : $("#descProd").val(),
				porcion     : $("#porcion").val(),
				unidadMedida: $("#uMedida").val(),
			},
			dataType: 'JSON',
			success: function (data) { 
				swal({
					type : 'success',
					title: data.message,
					onClose: () => {
						$("#cerrarProd").click();
						$("#descProd").val('');
						$("#porcion").val('');
						$("#noProd").html(data.totProd);
						/* Llamo a la función que agrega el producto nuevo a la tabla*/
						agregarProductoTable(data.totProd, data.desc, data.porcion, data.boton);
					}
				});
			},
			error: function (error) {
				if (error.responseJSON.message) {
					muestraAlerta('error', error.responseJSON.message);
					return;
				}
				if (error.responseJSON.errors.descripcion) {
					muestraAlerta('error', error.responseJSON.errors.descripcion[0]);
					return;
				}
				if (error.responseJSON.errors.unidadMedida) {
					muestraAlerta('error', error.responseJSON.errors.unidadMedida[0]);
					location.reload();
					return;
				}
				if (error.responseJSON.errors.porcion) {
					muestraAlerta('error', error.responseJSON.errors.porcion[0]);
					return;
				}
			}
		}); 
	} else { $("#form-producto")[0].reportValidity(); }
}

/* =============================================================
 * Funcion para mostar alertas referentes a la guia (tutorial)
 * $tipo    String [success, error, warning, info]
 * $titulo  String [Titulo del mensate]
 * $mensaje String [Mensaje de la alerta]
 *
 * ============================================================= */
 
function mostrarAlertaPopUp($tipo, $titulo, $mensaje, $msj) {
	$(document).ready(function(){
		/* Si falta algúna variable no hace nada */
		if( ($tipo === undefined) || ($mensaje === undefined) || ($titulo === undefined) ){
			return;
		} else {
			/* Si las variables están completas muestra una alerta con los 
			 * datos recibidos, la guia siempre regresará un popover para mostrar
			 * al usuario el siguiente paso que debe realizar, se debe mandar el
			 * nombre del objeto que contendrá el popover.
			 */
			swal({
				type : $tipo,
				title: $titulo,
				html : '<span class="hidden" msg="'+$msj+'"></span>'+ $mensaje,
				onClose: () => {
					mostrarPopoverGuia($('#paso1Guia'), 1);
				}
			});
		}
	});
}

/* =============================================================
 * Funcion para mostar popover referentes a la guía
 * 
 * $elemento String [Nombre del elemento HTML que contendrá el popover]
 * $paso     Integer [Número de paso, el mensaje se obtiene de la BD]
 *
 * ============================================================= */
 
function mostrarPopoverGuia($elemento, $paso) {
	$.ajax({
		url : 'guia',
		type: 'POST',
		data: {
			paso: $paso,
		},
		dataType: 'JSON',
		/* Si no hay errores regresa SUCCESS, inclusive si existen errores de validación y/o de BD */
		success: function (data) {
			if (data.status == 'success'){ 
				/* Agrego el popover al elemento recibido junto con la descripcion del paso */
				
				$($elemento).popover({
					placement: 'auto',
					trigger  : 'manual',
					container: 'body',
					html     : true,
					title    : $('meta[name="app-name"]').attr('content'),
					content  : '<center><span class="font-bold col-pink font-15">'+data.msg+'</span></center>', 
				});
				$($elemento).popover('show');
				return;
			}
			return;
		},
		error: function (data){
			console.log(data.msg);
			return;
		}
	});
}

/* =============================================================
 * Funcion para ocultar el popover, así se forza al usuario a
 * realizar una determinada acción de la guía.
 *
 *$paso String [Nombre del elemento que contiene el popover]
 * ============================================================= */
function quitarPopover($paso){ $($paso).popover('hide'); }

/* =============================================================
 * Función para agregar el producto nuevo en el data table
 * -Se agrega al inicio.
 * $num     Integer [Numero total del productos del usuario]
 * $desc    String  [Descripción del producto creado]
 * $porcion String  [Para cuantos - UM Ej. 100 - Personas]
 * $idProd  Integer [id del producto creado]
 * $idUSer  Integer [id del usuario]
 * 
 * ============================================================= */
function agregarProductoTable($num, $desc, $porcion, $url){
	/* Obtengo la tabla */
	var table = document.getElementById("tablaProd");
	/* Inserto una nueva fila */
	var row   = table.insertRow(0);
	/* Agrego los datos recibidos */
	row.insertCell(0).innerHTML = $num;
	row.insertCell(1).innerHTML = $desc;
	row.insertCell(2).innerHTML = $porcion;
	row.insertCell(3).innerHTML = '<span class="label bg-green">Activo</span>';
	row.insertCell(4).innerHTML = "Justo ahora";
	row.insertCell(5).innerHTML = $url;
}
/* =============================================================
 * Atiende al menu de botones
 * ============================================================= */
function linkmenu($id,$url,$href){
	$.ajax({
		url     : $url,
		type    : 'POST',
		data    : { iP: $id },
		dataType: 'JSON',
		success : function (){ 
			window.location.href = $href; 
		},
		error: function (data) {
			if (data.responseJSON.message)
			{
				muestraAlerta('error', data.responseJSON.message);
				location.reload();
				return;
			}
			if (data.responseJSON.errors.iP){
				muestraAlerta('error', data.responseJSON.errors.iP[0]);
				return;
			}
		}
	});
}
