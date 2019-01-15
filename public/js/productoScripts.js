/**======================================================================
 * Función que carga jExcel con algunos datos por default y los formatea
 * @author Emmanuel Hernández Díaz
 * ======================================================================
 */
 var ajaxBlock = function() { $.blockUI({message: 'Procesando...'}) }
$(document).ajaxStart(ajaxBlock).ajaxStop($.unblockUI);


	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

$(document).ready(function(){
    
	$.ajax({
		url     : '/producto/get_producto',
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

/**======================================================================
 * Función que formatea el como se muestran las etiquetas del gráfico
 * @author Emmanuel Hernández Díaz
 * ======================================================================
 */
function Guardar(){
    datos=LeerExcel()
	$.ajax({
		url     : '/producto/set_producto',
        data    :{datos:datos},
		type    : 'POST',
		dataType: 'JSON',
		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
		success : function (data) { 
		  
			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
			if (data['status'] == 'success')
			{
				swal({
					type : 'success',
					title: 'Mensaje',
					text : data.msg,
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
		error: function(data) {
			/* Si existió algún otro tipo de error se muestra en la consola */
			console.log(data)
		}
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
            
			if (col == 5 || col == 11  || col == 13 || col == 14 || col == 15) {
				$(cell).html(' $ ' + numeral($(cell).text()).format('0,0.00'));
			}
			if (col == 6 || col == 7 || col == 8 || col == 9 || col == 10 || col == 12) {
				$(cell).html(numeral($(cell).text()).format('0,0.00'));
			}
			if (col == 0 || col == 1 || col == 2 || col == 3 || col == 4 || col == 5
                || col == 6 || col == 8 || col == 9 || col == 10 || col == 11 || col == 14
                || col == 15){
				$(cell).addClass('readonly');
			}
            
            
            //Colores
            /*if (col == 0 || col == 1 || col == 2 || col == 3 || col == 4 || col == 5 || col==6)
                $(cell).css('background-color', '#eee');
            if (col == 8 )
                $(cell).css('background-color', '#7ec3ff');
            if (col == 10 || col == 11)
                $(cell).css('background-color', '#eee');*/
                
            if ($(cell).text() == 'TOTALES') {
                $('.r' + row).css('font-weight', 'bold');
                $('.r' + row).css('background-color', '#fffaa3');
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
	console.log('precioVenta: ');
	console.log(data.precioVenta);
	document.getElementById('sumCI').innerHTML         = data.sumCI;
	document.getElementById('recetaPara').innerHTML    = data.porcionpersona;
	document.getElementById('costounitario').innerHTML = data.costoUnitario;
	document.getElementById('costoUni').innerHTML      = data.costoUnitario;
	document.getElementById('precioVen').innerHTML     = data.precioVenta;
}


/**=========================================================================
 * Función que pinta el jExcel con los datos recibidos desde el controlador
 * =========================================================================
 */
function pintaJexcel(data)
{
        
	$('#mytable').jexcel({
		data             : data.data,
		colHeaders       : data.colHeaders,
		colWidths        : data.colWidths,
		allowInsertRow   : "false",
        allowManualInsertRow: "false",
		allowInsertColumn: "false",
		allowDeleteRow   : "false",
		allowDeleteColumn: "false",
        contextMenu      : "false",
		/* Tipos de columnas enviados desde el controlador */
		columns          :[
            { "type": "hidden"},
			{ "type": "text"},
			{ "type": "text"},
			{ "type": "text"},
            { "type": "text" },
            { "type": "numeric"},
            { "type": "numeric"}, 
            { "type": "numeric" },
            { "type": "hidden"},
            { "type": "hidden"},
            { "type": "hidden"},
            { "type": "numeric"},
            { "type": "numeric" },
           { "type": "numeric"},
            { "type": "numeric" }
		],

	});
}

/**=========================================================================
 * Leer excel
 * =========================================================================
 */
 
 function LeerExcel(){

    var data=$('#mytable').jexcel('getData');
    for(i=0;i<data.length;i++){
        for(j=0;j<data[i].length;j++){
            if(data[i][j].indexOf("=")==0)
                data[i][j]=$('#mytable input[value="'+data[i][j]+'"]').parent("td").text();
            else
                data[i][j]=data[i][j].replace(/[^A-Za-zÑñ0-9.\s]/g, "");
        }    
    }
        
    return data;
}

/**=========================================================================
 * Función actualiza el siguiente paso en el simulador del usuario
 * =========================================================================
 */
function siguiente(id)
{
	$(document).ready(function(){
		var url = $('meta[name="urlNext"]').attr('content');
		$.ajax({
			url : url,
			type: 'POST',
			data: {
				id: id,
			},
			dataType: 'JSON',
			/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
			success: function (data) { 
				 $('.content').empty();
				 $('.content').append(data);
			},
			/* Si existió algún otro tipo de error se muestra en la consola */
			error: function(data) {
				swal({
					type : 'error',
					title: 'Oops...',
					text : 'Error, copie y muestre este código al administrador: ' + data.responseJSON.message,
				});
			}
		});
	});
}

/**=========================================================================
 * Regresar al menu de productos
 * =========================================================================
 */
function regresar(){
    window.location.href = "/productomenu";
}