/*!

=========================================================
* Scripts para Dashboard de Simulador - v0.1
=========================================================

* Autor: Emmanuel Hernández Díaz
* Copyright 2018
* Integra Ideas Consultores

=========================================================

*/
$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
/*Funcion para agregar unidad de medida*/
function addUnidadMedida() {
	/* Espero a que el documento esté completamente cargado */
	$(document).ready(function(){
		if($("#formUnidadMedida")[0].checkValidity()) {
			/* Paso mediante ajax la descripcion insertada por el usuario */
			$.ajax({
				url: 'addUnidadMedida',
				type: 'POST',
				data: {
					descripcion :$("#descripcionUM").val()
				},
				dataType: 'JSON',
				/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
				success: function (data) { 
					/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
					if (data.status == 'success'){
						swal({
							type : 'success',
							title: data.option + ' agregada con éxito',
							onClose: () => {
								/* Cierra el modal de crear categoría y limpia los inputs*/
								$("#cerrarUM").click();
								$("#descripcionUM").val('');
								/* Actualiza el valor de las categorías en el dashboard */
								document.getElementById("numCatums").innerHTML = data.val;
								/* Se agrega al select el nuevo produco*/
								$("#uMedida")
									.append('<option value="'+data.val+'">'+data.option+'</option>')
									.selectpicker('refresh');
							}
						});
					/* Si hubo algún error se muestra al usuario para su correción */
					} else {
						swal({
							type : 'error',
							title: 'Oops...',
							text : data.msg,
						});
					}
					
				},
				error: function(data) {	console.log(data); }
			}); 
		} else { $("#formUnidadMedida")[0].reportValidity(); }
	}
)};

/*Funcion para agregar un producto nuevo*/
function addProducto() {
		/* Espero a que el docuemnto esté completamente cargado */
		$(document).ready(function(){
			if($("#form-producto")[0].checkValidity()) {
				/* Mando los datos introducidos por el usuario */
				$.ajax({
					url: 'addProducto',
					type: 'POST',
					data: {
						descripcion :$("#descProd").val(),
						porcion     :$("#porcion").val(),
						unidadMedida:$("#uMedida").val(),
					},
					dataType: 'JSON',
					/* Si no hay errores regresa SUCCESS, inclusi si existen errores de validación y/o de BD */
					success: function (data) { 
						/* Informa al usuario que el nuevo producto ha sido creado */
						if (data.status == 'success'){
							swal({
								type : 'success',
								title: data.msg,
								/* Cuando se cierra el modal limpia los campos y seleccion la primer opcion del select */
								onClose: () => {
									$("#cerrarProd").click();
									$("#descProd").val('');
									$("#porcion").val('');
									document.getElementById("noProd").innerHTML = data.totProd;
									/* Llamo a la funci´´on que agrega el producto nuevo a la tabla*/
									agregarProductoTable(data.totProd, data.desc, data.porcion, data.idProd, data.idUser, data.url);
								}
							});
						/* Si hubo algún error se muestra al usuario para su correción */
						} else {
							swal({
								type : 'error',
								title: 'Oops...',
								text : data.msg,
							});
						}
					},
					error: function(data) { console.log(data); }
				}); 
				}
			else { $("#form-producto")[0].reportValidity(); }
		}
	)}

/* =============================================================
 * Funcion para mostar alertas referentes a la guia (tutorial)
 * $tipo    String [success, error, warning, info]
 * $titulo  String [Titulo del mensate]
 * $mensaje String [Mensaje de la alerta]
 *
 * ============================================================= */
 
function mostrarAlerta($tipo, $titulo, $mensaje, $msj) {
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
function agregarProductoTable($num, $desc, $porcion, $idProd, $idUser, $url)
{
	/* Obtengo la tabla */
	var table = document.getElementById("tablaProd");
	/* Inserto una nueva fila */
	var row = table.insertRow(0);
	/* Agrego los datos recibidos */
	row.insertCell(0).innerHTML = $num;
	row.insertCell(1).innerHTML = $desc;
	row.insertCell(2).innerHTML = $porcion;
	row.insertCell(3).innerHTML = '<span class="label bg-green">Activo</span>';
	row.insertCell(4).innerHTML = "justo ahora";
	row.insertCell(5).innerHTML = $url;
}

/* Función que inicia el simulador, obteniendo el avance en el que se encuentra el usuario */
/*function comenzarSimulador($iP){ 
	$.ajax({
		url : 'iniciarSimulador',
		type: 'POST',
		data: {
			iP: $iP,
		},
		dataType: 'JSON',
		success: function (data) {
			if (data.status == 'success'){ 
				/* Redirijo al usuario a la página principal del simulador *
				window.location.href = "/simulador/inicio";
			} else { console.log(data); }
		},
		error: function (data){ console.log(data); }
	});
}*/

/* =============================================================
 * Atiende al menu de botones
 * 
 * ============================================================= */
function linkmenu($id,$url,$href)
{
	$.ajax({
		url : $url,
		type: 'POST',
		data: {
			iP: $id,
		},
		dataType: 'JSON',
		/* Si no hay errores regresa SUCCESS, inclusive si existen errores de validación y/o de BD */
		success: function (data) {
			if (data.status == 'success')
			{ 
				/* Redirijo al usuario a la página principal del simulador */
				window.location.href = $href;
			} else {
				console.log(data);
			}
		},
		error: function (data){
			console.log(data);
		}
	});
}
