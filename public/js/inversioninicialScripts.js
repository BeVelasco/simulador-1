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
		url     : '/inicial/get_inversion',
		type    : 'POST',
		dataType: 'JSON',
		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
		success : function (data) { 
		  
			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
			if (data['status'] == 'success')
			{
                $("#total").val(' $ ' + numeral(data["totalinversion"]).format('0,0.00'));
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
	$('#excelcapital').jexcel('updateSettings',{
	   cells: function (cell, col, row) {
            //Renglones con solo texto (titulos)
            if (row == 0 || row == 6 || row == 7 || row == 8 || row == 6 || row == 15 || row == 14) {
                $(cell).addClass('readonly');
                $(cell).css("color","#fff");
                $(cell).css("background","#333");
            }
            if (row == 2 && col==1) {
                $(cell).addClass('readonly');
            }
            
			if (col ==1 && row!=0 && row!=7 && row!=8 && row!=14 && row!=15) {
				$(cell).html(' $ ' + numeral($(cell).text()).format('0,0.00'));
			}
            if ((row == 6 || (row>=9 && row<=13) || (row>=16)) && col ==2) {
				$(cell).html(numeral($(cell).text()).format('0.00'));
			}
			if (col==0 || col ==2 || col ==3){
				$(cell).addClass('readonly');
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
	$('#excelcapital').jexcel({
		data             : data.datainversion,
		colHeaders       : ["Concepto","Importe","%","",""],
		colWidths        : [450, 90, 90, 90],
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
			{ "type": "hidden"},
            { "type": "hidden"},
		],
        onchange:function (obj, cel, val) {
            
            // Get the cell position x, y
            var id = $(cel).prop('id').split('-');
            
            if(id[0]!=2 && id[0]!=3)
                CalcularTotal();                                                                                
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
    		url     : '/inicial/set_inversion',
            data    :{
                        datos:datos,
                        totalinversion:$("#total").val(),
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
 * Calcular el total
 * =========================================================================
 */
function CalcularTotal(){
    var suma=0;
    
    value=$("#excelcapital td#1-6")[0].innerText.replace(/[^0-9.]/g, "");
    suma+=parseFloat((value!=""?value:0));
    
    for(i=9;i<=13;i++){
        value=$("#excelcapital td#1-" + i)[0].innerText.replace(/[^0-9.]/g, "");
        suma+=parseFloat((value!=""?value:0));
    }
    
    for(i=16;i<=23;i++){
        value=$("#excelcapital td#1-" + i)[0].innerText.replace(/[^0-9.]/g, "");
        suma+=parseFloat((value!=""?value:0));
    }
         
    $('#excelcapital td#3-6').removeClass("readonly");
    $('#excelcapital').jexcel('setValue', 'D7', suma);
    
    for(i=9;i<=13;i++){
        $('#excelcapital td#3-' + i).removeClass("readonly");
        $('#excelcapital').jexcel('setValue', 'D'+(i+1), suma);
        
        /*$('#excelactivos td#2-' + i).removeClass("readonly");
        $('#excelactivos').jexcel('setValue', 'C'+(i+1), "=IF(OR(B"+(i+1)+"<=0,D"+(i+1)+"<=0),0,B"+(i+1)+"/D"+(i+1)+"*100)");*/
    }    
    for(i=16;i<=23;i++){
        $('#excelcapital td#3-' + i).removeClass("readonly");
        $('#excelcapital').jexcel('setValue', 'D'+(i+1), suma);
    }
            
    
    $("#total").val(' $ ' + numeral(suma).format('0,0.00'));
    
}
/**=========================================================================
 * Leer excel
 * =========================================================================
 */
 
 function LeerExcel(){
    var celdasvacias=false;
    renglonconceldasvacias=[];
    
    var data=$('#excelcapital').jexcel('getData');
        
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