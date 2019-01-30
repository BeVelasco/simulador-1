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
                $("#sumatakttime").val(data["sumatakttime"]);
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




/**=========================================================================
 * Función que pinta el jExcel con los datos recibidos desde el controlador
 * =========================================================================
 */
function pintaJexcel(data)
{
        
	$('#excelformula').jexcel({
		data             : data.formulacion,
		colHeaders       : ["Procesos para la elaboración<br>del producto estandarización"
                            ,"Tiempo<br>realización","Cantidad","Insumos<br>relacionados"
                            ,"Personas<br>involucradas","Maquinaria","Herramientas"
                            ,"Check 1","Check 2","Check 3","Check 4","Check 5","Promedio"],
		colWidths        : [220, 90, 90, 90, 90, 90, 90, 90, 90, 90, 90, 90,90],
		allowInsertRow   : true,
        allowManualInsertRow: true,
		allowInsertColumn: true,
		allowDeleteRow   : true,
		allowDeleteColumn: true,
        contextMenu      : true,
		/* Tipos de columnas enviados desde el controlador */
		columns          :[
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
            if(id[0]!=12){
                $('td#12-'+id[1]).removeClass("readonly");
                $('#excelformula').jexcel('setValue', 'M' + (parseInt(id[1])+1), "=AVG(H" + (parseInt(id[1])+1) + ":L" + (parseInt(id[1])+1) +")");
                $('td#12-'+id[1]).addClass("readonly");
            }
            else{
                var suma=0;
                $(".c12").each(function(index, value){
                    suma+=parseFloat((value.innerText!=""?value.innerText:0));
                });
                $("#sumatakttime").val(Math.round(suma * 100) / 100);
            }
                
            //Obtener el valor de la celda con formula
            //$('input[value="=AVG(I1:M1)"]').parent("td").text();
        }
	});
    
    
    
    
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
    		url     : '/tkt/set_formulacion',
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
                        title: 'Mensaje',
					    text : data.msg,
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
			title: 'Mensaje',
            text : 'Existen celdas vacías (marcadas en amarillo) en una o más tablas del formulario, si desea continuar aún con las celdas vacías, marque la casilla "Guardar con celdas vacías" ubicada a la izquierda del botón "Guardar"',
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
    
    var data=$('#excelformula').jexcel('getData');
    for(i=0;i<data.length;i++){
        cantidadceldasrenglon=0;
        for(j=0;j<data[i].length;j++){//J=1 para saltar el ID que está oculto
            //Poner en blanco las celdas, por si anteriormente ya se habian marcado como vacias (amarillo)
            $('td#'+j+'-'+i).css("background-color","#fff");
            
            if(data[i][j].indexOf("=")==0)
                data[i][j]=$('#excelformula input[value="'+data[i][j]+'"]').parent("td").text();
            else{
                data[i][j]=data[i][j].replace(/[\$]/g, "");
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