/**======================================================================
 * Función que carga jExcel con algunos datos por default y los formatea
 * @author Emmanuel Hernández Díaz
 * ======================================================================
 */
 var renglonconceldasvacias=[];
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
                $("#total").val(' $ ' + numeral(data["sumanomina"]).format('0,0.00'));
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
            
			if (col >0 && col!=4) {
				$(cell).html(' $ ' + numeral($(cell).text()).format('0,0.00'));
			}
            if (col ==4) {
				$(cell).html(numeral($(cell).text()).format('0'));
			}
			if (col<3 || col >4){
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
		colHeaders       : ["Tipo de trabajador","De","A"
                            ,"Salario<br>Seleccionado<br>a pagar","Número de<br>Trabajadores<br>en tu empresa<br>por tipo de salario"
                            ,"Salario<br>Total<br>Mensual<br>"
                            ,"Salario <br>Total ANUAL<br>(Antes de prestaciones)<br><span style='background:#000;color:#fff;'>&nbsp;&nbsp;A&nbsp;&nbsp;</span>"
                            ,"Prima Vacacional ANUAL<br>25% sobre 6 días de sueldo,<br>Promedio anual de vacaciones<br>(primer año según LFT)<br><span style='background:#993300;color:#fff;'>&nbsp;&nbsp;B&nbsp;&nbsp;</span>"
                            ,"Aguinaldo ANUAL<br>15 días<br>de salario<br><span style='background:#993300;color:#fff;'>&nbsp;&nbsp;C&nbsp;&nbsp;</span>"
                            ,"Salario <br>Total ANUAL<br>INTEGRADO<br>(Después de prestaciones)<br><span style='background:#000;color:#fff;'>&nbsp;&nbsp;D=A+B+C&nbsp;&nbsp;</span>"
                            ,"Cuotas de Seguridad Social,<br>Aportación patronal,<br>Tasa promedio aproximada:<br>25%<br><span style='background:#800080;color:#fff;'>&nbsp;&nbsp;E=D al 25%A&nbsp;&nbsp;</span>"
                            ,"Cuotas de Fondo Nacional para la Vivienda,<br>Aportación patronal,<br>Tasa promedio aproximada:<br>5%<br><span style='background:#800080;color:#fff;'>&nbsp;&nbsp;F=D al 25%&nbsp;&nbsp;</span>"
                            ,"Fondo de Ahorro para el retiro,<br>Aportación patronal,<br>Tasa promedio aproximada:<br>2%<br><span style='background:#800080;color:#fff;'>&nbsp;&nbsp;G=D al 2%&nbsp;&nbsp;</span>"
                            ,"Total impuestos/contribuciones<br>laborales mínimas<br>Aportación patronal<br><span style='background:#000;color:#fff;'>&nbsp;&nbsp;H=E+F+G&nbsp;&nbsp;</span>"
                            ,"TOTAL IMPORTE DE:<br>SALARIOS Y OBLIGACIONES<br>ANUALES A CARGO<br>DEL PATRÓN<br><span style='background:#000;color:#fff;'>&nbsp;&nbsp;D+H&nbsp;&nbsp;</span>"
                            ],
		colWidths        : [5,220, 90, 90, 90, 90, 90, 90, 90, 90, 90, 90, 90,90, 90, 90,90, 90, 90,90],
		allowInsertRow   : false,
        allowManualInsertRow: false,
		allowInsertColumn: false,
		allowDeleteRow   : false,
		allowDeleteColumn: false,
        contextMenu      : false,
		/* Tipos de columnas enviados desde el controlador */
		columns          :[
            { "type": "text"},
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
            
            if(id[0]==3 || id[0]==4){
                var suma=0;
                $(".c14").each(function(index, value){
                    suma+=parseFloat((value.innerText!=""?value.innerText.replace(/[^0-9.]/g, ""):0));
                });
                
                $("#total").val(' $ ' + numeral((Math.round(suma) * 100) / 100).format('0,0.00'));
                
                //Validaciones
                if (id[0]==3){
                    var sueldo=$('td#3-'+id[1])[0].innerText.replace(/[^0-9.]/g, "");
                    var liminicio=$('td#1-'+id[1])[0].innerText.replace(/[^0-9.]/g, "");
                    var limfin=$('td#2-'+id[1])[0].innerText.replace(/[^0-9.]/g, "");
                    
                    if(parseFloat(sueldo)<liminicio || parseFloat(sueldo)>limfin){
                        //Poner en amarillo si no tiene contenido
                        $('td#3-'+id[1]).css("background-color","#ff0");
                    }
                    else
                        $('td#3-'+id[1]).css("background-color","#fff");
                }
            }
            
            
        }
	});
    
    $('#excelnomina').find('thead tr').before(
            '<tr>'
        +'<td>&nbsp;</td>'
        +'<td>&nbsp;</td>'
        +'<td colspan="2">Sueldo mensual</td>'
        +'<td colspan="4">&nbsp;</td>'
        +'<td colspan="2">Prestaciones sociales m&iacute;nimas</td>'
        +'<td>&nbsp;</td>'
        +'<td colspan="3">Promedio de impuestos/contribuciones laborales m&iacute;nimas</td>'
        +'<td>&nbsp;</td>'
        +'<td>&nbsp;</td>'
        +'</tr>');
}

/**======================================================================
 * Función para guardar los datos
 * @author JAVG
 * ======================================================================
 */
function Guardar(){
    datos=LeerExcel()
	
    if(renglonconceldasvacias.length==0){
    	$.ajax({
    		url     : '/nomina/set_formulacion',
            data    :{
                        datos:datos,
                        sumatakttime:$("#sumatakttime").val(),
                    },
    		type    : 'POST',
    		dataType: 'JSON',
    		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
    		success : function (data) { 
    		  
    			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
    			if (data['status'] == 'success')
    			{
    				swal({
    					type : 'success',
    					title: data.msg,
    					//text : data.msg,
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
    else{
        swal({
			type : 'error',
			title: 'Existen celdas vacías (marcadas en amarillo) en una o más tablas del formulario, si desea continuar aún con las celdas vacías, marque la casilla "Guardar con celdas vacías" ubicada a la izquierda del botón "Guardar"',
			onClose: () => {
				
			}
		});
    }
}

/**=========================================================================
 * Leer excel
 * =========================================================================
 */
 
 function LeerExcel(){
    var celdasvacias=false;
    renglonconceldasvacias=[];
    
    var data=$('#excelnomina').jexcel('getData');
    for(i=0;i<data.length;i++){
        cantidadceldasrenglon=0;
        for(j=1;j<data[i].length;j++){//J=1 para saltar el ID que está oculto
            //Poner en blanco las celdas, por si anteriormente ya se habian marcado como vacias (amarillo)
            $('td#'+j+'-'+i).css("background-color","#fff");
            
            if(data[i][j].indexOf("=")==0)
                data[i][j]=$('#excelnomina input[value="'+data[i][j]+'"]').parent("td").text();
            else{
                data[i][j]=data[i][j].replace(/[^A-Za-zÑñ0-9.\s]/g, "");
                if(data[i][j]=="" 
                    //&& data.length>1 
                    && (!($("#chkGuardarvacias").is(":checked"))) 
                    ){
                    //Poner en amarillo si no tiene contenido
                    $('td#'+j+'-'+i).css("background-color","#ff0");
                    celdasvacias=true;
                    cantidadceldasrenglon++;
                }
            }
        }    
        if(celdasvacias){
            //Las celdas vacias son las misma cantidad de celdas existentes
            if(cantidadceldasrenglon==data[i].length-1){//-1 por la columna ID que no se toma en cuenta
                for(j=1;j<data[i].length;j++){
                    //Poner en blanco las celdas, por si anteriormente ya se habian marcado como vacias (amarillo)
                    $('td#'+j+'-'+i).css("background-color","#fff");
                }    
            }
            else
                renglonconceldasvacias.push(i)
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
    window.location.href = "/home";
}