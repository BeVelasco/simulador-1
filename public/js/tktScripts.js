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
		url     : '/tkt/get_formulacion',
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
	$('#excelformula').jexcel('updateSettings',{
		table: function (instance, cell, col, row, val, id) {
            
			/*if (col == 5 || col == 11  || col == 13 || col == 14 || col == 15) {
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
            */
            
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
 * Función para hacer promedio en JExcel
 * @author Emmanuel Hernández Díaz
 * ======================================================================
 */
function AVG(v)
{
    var sum = v.reduce(function(a, b) { return a + b; });
    var avg = sum / v.length;

    return avg;
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
        
	$('#excelformula').jexcel({
		data             : data.formulacion,
		colHeaders       : ["ID","Procesos para la elaboración<br>del producto estandarización"
                            ,"Tiempo<br>realización","Cantidad","Insumos<br>relacionados"
                            ,"Personas<br>involucradas","Maquinaria","Herramientas"
                            ,"Check 1","Check 2","Check 3","Check 4","Check 5","Promedio"],
		colWidths        : [5,220, 90, 90, 90, 90, 90, 90, 90, 90, 90, 90, 90,90],
		allowInsertRow   : true,
        allowManualInsertRow: true,
		allowInsertColumn: true,
		allowDeleteRow   : true,
		allowDeleteColumn: true,
        contextMenu      : true,
		/* Tipos de columnas enviados desde el controlador */
		columns          :[
            { "type": "hidden"},
			{ "type": "text"},
			{ "type": "numeric"},
			{ "type": "numeric"},
            { "type": "text" },
            { "type": "numeric"},
            { "type": "text"}, 
            { "type": "text" },
            { "type": "numeric"},
            { "type": "numeric"},
            { "type": "numeric"},
            { "type": "numeric"},
            { "type": "numeric" },
           { "type": "numeric",readOnly:true},
		],
        onchange:function (obj, cel, val) {
            
            // Get the cell position x, y
            var id = $(cel).prop('id').split('-');
            if(id[0]!=13){
                //$('td#13-'+id[1]).html('<input type="hidden" value="=AVG(I' + (parseInt(id[1])+1) + ':M' + (parseInt(id[1])+1) +')">');
                $('td#13-'+id[1]).removeClass("readonly");
                $('#excelformula').jexcel('setValue', 'N' + (parseInt(id[1])+1), "=AVG(I" + (parseInt(id[1])+1) + ":M" + (parseInt(id[1])+1) +")");
                $('td#13-'+id[1]).addClass("readonly");
            }
            else{
                var suma=0;
                $(".c13").each(function(index, value){
                    suma+=parseFloat((value.innerText!=""?value.innerText:0));
                });
                $("#total").val(Math.round(suma * 100) / 100);
            }
                
            //Obtener el valor de la celda con formula
            //$('input[value="=AVG(I1:M1)"]').parent("td").text();
        }
	});
    
    /* tiempo de elaboración */
    $("#exceltiempo").jexcel({
		data             : data.tiempo,
		colHeaders       : ["MEDICIÓN DE TIEMPOS","TOTAL AL 100%"],
		colWidths        : [220, 220],
		allowInsertRow   : false,
        allowManualInsertRow: false,
		allowInsertColumn: false,
		allowDeleteRow   : false,
		allowDeleteColumn: false,
        contextMenu      : false,
		/* Tipos de columnas enviados desde el controlador */
		columns          :[
			{ "type": "text",readOnly:true},
			{ "type": "numeric"},
		],
    });
    
    /* tiempos agregados */
    $("#excelagregados").jexcel({
		data             : data.agregados,
		colHeaders       : ["Producto DOS","Almacén<br>de M.P.","Líneas de<br>producción","Almacén","Canal de<br>distribución","Venta final"],
		colWidths        : [220, 100, 100, 100, 100, 100],
		allowInsertRow   : true,
        allowManualInsertRow: true,
		allowInsertColumn: true,
		allowDeleteRow   : true,
		allowDeleteColumn: true,
        contextMenu      : true,
		/* Tipos de columnas enviados desde el controlador */
		columns          :[
			{ "type": "text"},
			{ "type": "text"},
            { "type": "text"},
            { "type": "text"},
            { "type": "text"},
            { "type": "text"},
		],
    });
    
    /* tiempos agregados */
    $("#excelgastos").jexcel({
		data             : data.gastos,
		colHeaders       : ["Descripción","Gasto<br>mensual","Gasto<br>por lote"],
		colWidths        : [220, 100, 100],
		allowInsertRow   : true,
        allowManualInsertRow: true,
		allowInsertColumn: true,
		allowDeleteRow   : true,
		allowDeleteColumn: true,
        contextMenu      : true,
		/* Tipos de columnas enviados desde el controlador */
		columns          :[
			{ "type": "text"},
			{ "type": "text"},
            { "type": "text"},
		],
    });
    
    
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