/*!

=========================================================
* Scripts para Dashboard de Simulador - v0.1
=========================================================

* Autor: Emmanuel Hernández Díaz
* Copyright 2018
* Integra Ideas Consultores

=========================================================

*/
var ajaxBlock = function() { $.blockUI({message: 'Procesando...'}) }
$(document).ajaxStart(ajaxBlock).ajaxStop($.unblockUI);

$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});


function editarProducto($id)
{
	$.ajax({
		url : '/producto/editarProducto',
		type: 'POST',
		data: {
			id: $id,
		},
		dataType: 'JSON',
		/* Si no hay errores regresa SUCCESS, inclusive si existen errores de validación y/o de BD */
		success: function (data) {
			if (data.status == 'success')
			{ 
				/* Redirijo al usuario a la página principal del simulador */
				window.location.href = "/producto/editarInicio";
			} else {
				console.log(data);
			}
		},
		error: function (data){
			console.log(data);
		}
	});
}

