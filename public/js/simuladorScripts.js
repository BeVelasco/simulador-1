/**======================================================================
 * Función que carga jExcel con algunos datos por default y los formatea
 * @author Emmanuel Hernández Díaz
 * ======================================================================
 */
$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		url     : '/simulador/getData',
		type    : 'POST',
		dataType: 'JSON',
		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
		success : function (data) { 
			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
			if (data['status'] == 'success')
			{
				/* Muestra jExcel con los datos recibidos */
				pintaJexcel(data);

				/* Formatea las celdas */
				formateaCeldas();

				/* Si ya se hizo el cálculo muestra los divs ocultos y el grafico */
				if (data.datosCalculados == true)
				{
					muestraOcultos();
					muestraGrafico(data.graphicData);
				}

			/* Si hubo algún error se muestra al usuario para su correción */
			} else {
				swal({
					type : 'error',
					title: 'Oops...',
					text : data.msg,
				});
			}	
		},
		error: function(data) {
			/* Si existió algún otro tipo de error se muestra en la consola */
			console.log(data)
		}
	});
});

/*======================================================================
 * Función que envía los datos capturados por el usuario para calcular
 * el costo de cada ingrediente
 *
 * @author Emmanuel Hernández Díaz
 *======================================================================
*/
function calcularPrecioVenta()
{
	$(document).ready(function(){
		if($("#formPrecioVenta")[0].checkValidity()) {
			/* Agrego la cabecera para pasar el csrf */
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url : '/simulador/calcularPrecioVenta',
				type: 'POST',
				data: {
					jExcel: $('#mytable').jexcel('getData'),
					PBBD  : $('#PBBD').val(),
				},
				dataType: 'JSON',
				/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
				success: function (data) { 
					/* Si se hizo el cálculo sin problemas se le notifica al usuario  */
					if (data['status'] == 'success')
					{
						swal({
							type : 'success',
							title: 'Ok',
							text : '¡'+data.msg+'!'
						});
						/* Muestro el jExcel con los datos recibido */
						pintaJexcel(data);

						/* Actualizo los datos contenidos en el texto de la página web */
						actualizaDatos(data);

						/* Muestro los divs ocultos */
						$('#divResultados2').show();
						$('#divBtnSiguiente').show();
						$('#divResultados').show();	

						/* Pinta el gráfico con los datos recibidos */
						muestraGrafico(data.graphicData);
						
						/* Formatea las celdas */
						formateaCeldas();

					/* Si hubo algún error se muestra al usuario para su correción */
					} else {
						swal({
							type : 'error',
							title: 'Oops...',
							text : data.msg,
						});
					}
				},
				/* Si existió algún otro tipo de error se muestra en la consola */
				error: function(data) {
					console.log(data)
				}
			}); 
		} else {
			$("#formPrecioVenta")[0].reportValidity();
		}
	});
}

/**======================================================================
 * Función que recibe los datos para pintar el gráfico tipo PIE
 * @author Emmanuel Hernández Díaz
 * ======================================================================
 */
function muestraGrafico(graphicData)
{
	/* Cambio el ancho del gráfico, para acoplarse al div que ko contiene*/
	var ancho = $('#divGrafica').width();
	$("#divGrafica").width(ancho);
	$("#divGrafica").height(ancho);

	/* PLOT */
	data            = JSON.parse(graphicData);
	var placeholder = $("#divGrafica");
	placeholder.unbind();
	$.plot('#divGrafica', data, {
		series: {
			pie: {
				show  : true,
				radius: 1,
				label : {
					show     : true,
					radius   : 2/3,
					formatter: labelFormatter,
					threshold: 0.1,
				}
			}
		},
		legend: {
			show: false,
		},
	});
}

/**======================================================================
 * Función que formatea el como se muestran las etiquetas del gráfico
 * @author Emmanuel Hernández Díaz
 * ======================================================================
 */
function labelFormatter(label, series) {
	return "<div style='font-size:8pt; text-align:center; padding:2px; color:black;'>" + label + "<br/>" + series.percent + "%</div>";
}

/**======================================================================
 * Función que formatea las celdas para que se muestren con 2 decimales,
 * y/o de solo lectura.
 * @author Emmanuel Hernández Díaz
 * ======================================================================
 */
function formateaCeldas(){
	$('#mytable').jexcel('updateSettings',{
		table: function (instance, cell, col, row, val, id) {
			if (col == 4 || col == 3) {
				$(cell).html(' $ ' + numeral($(cell).text()).format('0,0.00'));
			}
			if (col == 2 || col == 1) {
				$(cell).html(numeral($(cell).text()).format('0,0.00'));
			}
			if (col == 5){
				$(cell).addClass('readonly');
			}
		}
	});
}

/**======================================================================
 * Función que actualiza los datos en el texto de la página web
 * @author Emmanuel Hernández Díaz
 * ======================================================================
 */
function actualizaDatos(data)
{
	document.getElementById('sumCI').innerHTML         = data.sumCI;
	document.getElementById('recetaPara').innerHTML    = data.porcionpersona;
	document.getElementById('costounitario').innerHTML = data.costoUnitario;
	document.getElementById('costoUni').innerHTML      = data.costoUnitario;
	document.getElementById('precioVen').innerHTML     = data.precioVenta;
}

/**======================================================================
 * Función que muestra los divs ocultos (gráfico, resultados y botón)
 * @author Emmanuel Hernández Díaz
 * ======================================================================
 */
function muestraOcultos()
{
	$('#divSuma').show();
	$('#divResultados2').show();
	$('#divBtnSiguiente').show();
}

/**=========================================================================
 * Función que pinta el jExcel con los datos recibidos desde el controlador
 * @author Emmanuel Hernández Díaz
 * =========================================================================
 */
function pintaJexcel(data)
{
	$('#mytable').jexcel({
		data             : data.data,
		colHeaders       : data.colHeaders,
		colWidths        : data.colWidths,
		allowInsertRow   : data.allowInsertRow,
		allowInsertColumn: data.allowInsertColumn,
		allowDeleteRow   : data.allowDeleteRow,
		allowDeleteColumn: data.allowDeleteColumn,
		/* Tipos de columnas enviados desde el controlador */
		columns    : JSON.parse(data.columns),

	});
}