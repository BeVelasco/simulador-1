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

//Array de formulas
var formulas=[];

$(document).ready(function(){
    
	$.ajax({
		url     : '/nomina/get_nomina',
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
	$('#excelnomina').jexcel('updateSettings',{
		table: function (instance, cell, col, row, val, id) {
            
			/*if (col == 5 || col == 11  || col == 14 || col == 14 || col == 15) {
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
    //recibir las formulas de las celdas para aplicarlas en los renglones nuevos
    formulas=data.formulas;
    
	$('#excelnomina').jexcel({
		data             : data.datanomina,
		colHeaders       : ["ID","De","A"
                            ,"Salario<br>Seleccionado<br>a pagar","Número de<br>Trabajadores<br>en tu empresa<br>por tipo de salario"
                            ,"Salario<br>Total<br>Mensual<br>"
                            ,"Salario <br>Total ANUAL<br>(Antes de prestaciones)"
                            ,"Prima Vacacional ANUAL<br>25% sobre 6 días de sueldo,<br>Promedio anual de vacaciones<br>(primer año según LFT)"
                            ,"Aguinaldo ANUAL<br>15 días<br>de salario"
                            ,"Salario <br>Total ANUAL<br>INTEGRADO<br>(Después de prestaciones)"
                            ,"Cuotas de Seguridad Social,<br>Aportación patronal,<br>Tasa promedio aproximada:<br>25%"
                            ,"Cuotas de Fondo Nacional para la Vivienda,<br>Aportación patronal,<br>Tasa promedio aproximada:<br>5%"
                            ,"Fondo de Ahorro para el retiro,<br>Aportación patronal,<br>Tasa promedio aproximada:<br>2%"
                            ,"Total impuestos/contribuciones<br>laborales mínimas<br>Aportación patronal"
                            ,"TOTAL IMPORTE DE:<br>SALARIOS Y OBLIGACIONES<br>ANUALES A CARGO<br>DEL PATRÓN"
                            ],
		colWidths        : [5,220, 90, 90, 90, 90, 90, 90, 90, 90, 90, 90, 90,90, 90, 90,90, 90, 90,90],
		allowInsertRow   : true,
        allowManualInsertRow: true,
		allowInsertColumn: true,
		allowDeleteRow   : true,
		allowDeleteColumn: true,
        contextMenu      : true,
		/* Tipos de columnas enviados desde el controlador */
		columns          :[
            { "type": "hidden"},
			{ "type": "numeric"},
			{ "type": "numeric"},
			{ "type": "numeric"},
            { "type": "numeric"},
            { "type": "numeric"},
            { "type": "numeric"}, 
            { "type": "numeric"},
            { "type": "numeric"},
            { "type": "numeric"},
            { "type": "numeric"},
            { "type": "numeric"},
            { "type": "numeric"},
            { "type": "numeric"},
            { "type": "numeric"},
            { "type": "numeric"},
		],
        onchange:function (obj, cel, val) {
            
            // Get the cell position x, y
            var id = $(cel).prop('id').split('-');
            debugger
            if(id[0]<=4){
                for(i=0;i<15;i++){
                    //$('td#14-'+id[1]).html('<input type="hidden" value="=AVG(I' + (parseInt(id[1])+1) + ':M' + (parseInt(id[1])+1) +')">');
                    $('td#' + i + '-'+ id[1]).removeClass("readonly");
                    $('#excelnomina').jexcel('setValue', formulas[i][1] + (parseInt(id[1])+1), formulas[i][0]);
                    $('td#' + i + '-'+ id[1]).addClass("readonly");    
                }
                
            }
            else{
            debugger
                var suma=0;
                $(".c14").each(function(index, value){
                    suma+=parseFloat((value.innerText!=""?value.innerText:0));
                });
                $("#total").val(Math.round(suma * 100) / 100);
            }
            
            
        }
	});
    
    $('#excelnomina').find('thead tr').before(
            '<tr>'
        +'<td>&nbsp;</td>' 
        +'<td>&nbsp;</td>'
        +'<td>&nbsp;</td>'
        +'<td colspan="2">Sueldo mensual</td>'
        +'<td colspan="3">&nbsp;</td>'
        +'<td colspan="2">Prestaciones sociales m&iacute;nimas</td>'
        +'<td>&nbsp;</td>'
        +'<td colspan="3">Promedio de impuestos/contribuciones laborales m&iacute;nimas</td>'
        +'<td>&nbsp;</td>'
        +'<td>&nbsp;</td>'
        +'</tr>');
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