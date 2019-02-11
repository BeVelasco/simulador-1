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
		url     : '/inicial/get_situacion',
		type    : 'POST',
		dataType: 'JSON',
		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
		success : function (data) { 
		  
			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
			if (data['status'] == 'success')
			{
                $("#totalgastos").val(' $ ' + numeral(data["totalgastos"]).format('0,0.00'));
				/* Muestra jExcel con los datos recibidos */
				pintaDatos(data);
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
	$('#excelsituacion').jexcel('updateSettings',{
	   cells: function (cell, col, row) {
            //Renglones con solo texto (titulos)
            if ($('#excelsituacion td#4-'+row)[0].innerText.indexOf("ne-")>=0) {
                cols=$('#excelsituacion td#4-'+row)[0].innerText.substr(3).split(",")
                for(i=0;i<cols.length;i++){
                    celda=$('#excelsituacion td#'+cols[i]+'-'+row)[0]
                    $(celda).addClass('readonly');
                    $(celda).css("color","#fff");
                    $(celda).css("background","#333");
                }
            }
            /*if (row == 2 && col==1) {
                $(cell).addClass('readonly');
            }
            */
			if (col ==1 || col==3) {
                if($(cell)[0].innerText!="")
				    $(cell).html(' $ ' + numeral($(cell).text()).format('0,0.00'));
			}/*
            if ((row == 6 || (row>=9 && row<=13) || (row>=16)) && col ==2) {
				$(cell).html(numeral($(cell).text()).format('0.00'));
			}*/
		}
	});
    
    $('#excelventas').jexcel('updateSettings',{
	   cells: function (cell, col, row) {
			if (col ==1 || col==3) {
                if($(cell)[0].innerText!="")
				    $(cell).html(' $ ' + numeral($(cell).text()).format('0,0.00'));
			}
		}
	});
    
    $('#excelgastos').jexcel('updateSettings',{
	   cells: function (cell, col, row) {
            //Renglones con solo texto (titulos)
            if ($('#excelgastos td#4-'+row)[0].innerText.indexOf("ne-")>=0) {
                cols=$('#excelgastos td#4-'+row)[0].innerText.substr(3).split(",")
                for(i=0;i<cols.length;i++){
                    celda=$('#excelgastos td#'+cols[i]+'-'+row)[0]
                    $(celda).addClass('readonly');
                    $(celda).css("color","#fff");
                    $(celda).css("background","#333");
                }
            }
            /*if (row == 2 && col==1) {
                $(cell).addClass('readonly');
            }
            */
			if ((col ==1 || col==3) && row!=0) {
                if($(cell)[0].innerText!="")
				    $(cell).html(' $ ' + numeral($(cell).text()).format('0,0.00'));
			}/*
            if ((row == 6 || (row>=9 && row<=13) || (row>=16)) && col ==2) {
				$(cell).html(numeral($(cell).text()).format('0.00'));
			}*/
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
function pintaDatos(data)
{
	$('#excelsituacion').jexcel({
		data             : data.datasituacion,
		colHeaders       : ["","","","",""],
		colWidths        : [450, 90, 450, 90],
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
			{ "type": "text"},
			{ "type": "numeric"},
            { "type": "hidden"},
		],
	});
    
   $('#excelventas').jexcel({
		data             : data.dataventas,
		colHeaders       : ["","","","",""],
		colWidths        : [450, 90, 450, 90],
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
			{ "type": "text"},
			{ "type": "numeric"},
            { "type": "hidden"},
		],
        
	});
    
    //Costo de ventas
    $("#anio1costos").val(data["costoprimo"]);
    $("#anio2costos").val(data["costoprimo"]);
    $("#anio3costos").val(data["costoprimo"]);
    
    
    
    $('#excelgastos').jexcel({
		data             : data.datagastos,
		colHeaders       : ["","","","",""],
		colWidths        : [450, 90, 450, 90],
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
			{ "type": "text"},
			{ "type": "numeric"},
            { "type": "hidden"},
		],
        onchange:function (obj, cel, val) {
            
            // Get the cell position x, y
            var id = $(cel).prop('id').split('-');
            
            if(id[0]!=0 && id[0]!=2)
                CalcularTotalGastos();                                                                                
        }
	});
    
    //adicionales de gastos
    $("#anio1gastos").val(data.datagastosinc[0]["porcgastos2"]);
    $("#anio2gastos").val(data.datagastosinc[1]["porcgastos3"]);
    
    //Tasa de descuento
    $("#tasalider").val(data.datatasadescuento[0]["tasalider"]);
    $("#primariesgo").val(data.datatasadescuento[1]["primariesgo"]);
    $("#riesgopais").val(data.datatasadescuento[2]["riesgopais"]);
}
/**=========================================================================
 * Calcular el total de gastos
 * =========================================================================
 */
function CalcularTotalGastos(){
    var suma=0;
    
    value=0;
    suma+=parseFloat((value!=""?value:0));
    
    for(i=1;i<$("#excelgastos tbody tr").length;i++){
        value=$("#excelgastos td#1-" + i)[0].innerText.replace(/[^0-9.]/g, "");
        suma+=parseFloat((value!=""?value:0));
        value=$("#excelgastos td#3-" + i)[0].innerText.replace(/[^0-9.]/g, "");
        suma+=parseFloat((value!=""?value:0));
    }
    
    $("#totalgastos").val(' $ ' + numeral(suma).format('0,0.00'));
    
}
/**======================================================================
 * Función para guardar los datos
 * @author JAVG
 * ======================================================================
 */
function Guardar(){
    
	var msg=validarForms();
    if(msg==true){
        //Leer datos del formulario
        datos=LeerDatos()
        if(renglonconceldasvacias.length==0){
        	$.ajax({
        		url     : '/inicial/set_situacion',
                data    :{
                            datos:datos,
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
        					title: 'Error',
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
                title: 'Error',
    			text: 'Existen celdas vacías (marcadas en amarillo) en una o más tablas del formulario, si desea continuar aún con las celdas vacías, marque la casilla "Guardar con celdas vacías" ubicada a la izquierda del botón "Guardar"',
    			onClose: () => {
    				
    			}
    		});
        }
    }
    else{
        if(msg.length>0){
            swal.fire({
    			type : 'error',
    			title: 'Error',
                html : msg,
    			onClose: () => {
    			     //Volver a llamar a la función para que muestre los mensajes
    		          validarForms();		
    			}
    		});
            
            
        }
    }
}

/**=========================================================================
 * Validaciones de formularios, campos de edición que no sean JExcel
 * =========================================================================
 */
function validarForms(){
    var msg="";
    if($("#porcentajeGastos")[0].checkValidity()) {
        return true;
   	} 
    else 
    { 
        $("#porcentajeGastos").find("input").each(function(i,o){
            var c=document.getElementById(o.id);
            if(!c.checkValidity()){
                var tabid=$("#"+c.id).parents("[role='tabpanel']").attr("id");
                var tabtitle=$(document).find("a[href='#" + tabid +"']").html()
                var tab=$(document).find("a[href='#" + tabid +"']");
                
                msg="Existen campos en la sección '" + tabtitle + "' que no superan las reglas de validación <br>"
                
                tab.trigger('click');
                return true;
            }  
        });
        
        if($("#porcentajeGastos").is(":visible")){
            $("#porcentajeGastos")[0].reportValidity();
            return "";
        }
        else{
            msg+="<br>Favor de verificar"
            return msg;
        }
    }
}


/**=========================================================================
 * Leer excel
 * =========================================================================
 */
 
 function LeerDatos(){
    var celdasvacias=false;
    renglonconceldasvacias=[];
    
    var data=Array();
    data.push({"prestamoaccionistas":LeerExcel("excelsituacion",8,3)}); //nombre de la tabla, renglon(r) y columna(c) 
    data.push({"prestamolargoplazo":LeerExcel("excelsituacion",9,3)}); 
    data.push({"inversionaccionistas":LeerExcel("excelsituacion",12,3)});
    data.push({"utilidadreservas":LeerExcel("excelsituacion",13,3)});
    
    data.push({"porcgastos2":$("#anio1gastos").val().replace(/[\$,]/g, "")});
    data.push({"porcgastos3":$("#anio2gastos").val().replace(/[\$,]/g, "")});
    
    data.push({"oficinas":LeerExcel("excelgastos",1,1)});
    data.push({"servpublicos":LeerExcel("excelgastos",3,1)});
    data.push({"telefonos":LeerExcel("excelgastos",4,1)});
    data.push({"seguros":LeerExcel("excelgastos",5,1)});
    data.push({"papeleria":LeerExcel("excelgastos",6,1)});
    data.push({"rentaequipo":LeerExcel("excelgastos",7,1)});
    data.push({"costoweb":LeerExcel("excelgastos",8,1)});
    data.push({"costoconta":LeerExcel("excelgastos",9,1)});
    
    data.push({"honorariolegal":LeerExcel("excelgastos",1,3)});
    data.push({"viajesysubsistencia":LeerExcel("excelgastos",2,1)});
    data.push({"gastosautos":LeerExcel("excelgastos",3,1)});
    data.push({"gastosgenerales":LeerExcel("excelgastos",4,1)});
    data.push({"cargosbancarios":LeerExcel("excelgastos",5,1)});
    data.push({"otrosservicios":LeerExcel("excelgastos",6,1)});
    data.push({"gastosinvestigacion":LeerExcel("excelgastos",8,1)});
    data.push({"gastosdiversos":LeerExcel("excelgastos",9,1)});
    
    data.push({"totalgastos":$("#totalgastos").val().replace(/[\$,]/g, "")});
    
    data.push({"tasalider":$("#tasalider").val().replace(/[\$,]/g, "")});
    data.push({"primariesgo":$("#primariesgo").val().replace(/[\$,]/g, "")});
    data.push({"riesgopais":$("#riesgopais").val().replace(/[\$,]/g, "")});
    
    data.push({"tasalargoplazo":$("#tasalargoplazo").val().replace(/[\$,]/g, "")});
    data.push({"tasacortoplazo":$("#tasacortoplazo").val().replace(/[\$,]/g, "")});
    data.push({"interesexcedente":$("#interesexcedente").val().replace(/[\$,]/g, "")});
        
    return data;
}

/**=========================================================================
 * Leer excel
 * =========================================================================
 */
 
 function LeerExcel(idExcel,i,k){
    var celdasvacias=false;
    renglonconceldasvacias=[];
    
    var data=$('#' + idExcel).jexcel('getData');
    //var datos=Array();//El JExcel al poner dos filas mete columnas duplicadas y en null, por eso se crea otro array para ir copiando los valores validos
    var dato=0;
    
    //for(i=0;i<data.length;i++){
        cantidadceldasrenglon=0;
        //var row=Array();
        
        //for(k=0;k<data[i].length;k++){//J=1 para saltar el ID que está oculto
            //Poner en blanco las celdas, por si anteriormente ya se habian marcado como vacias (amarillo)
            //$('td#'+k+'-'+i).css("background-color","#fff");
            
            if(data[i][k]!=null){
                if(data[i][k].indexOf("=")==0)
                    data[i][k]=$('#excelnomina input[value="'+data[i][k]+'"]').parent("td").text().replace(/[\$,]/g, "");
                else{
                    if(data[i][k].indexOf("$")>=0)
                        data[i][k]=data[i][k].replace(/[\$,]/g, "");
                    else
                        data[i][k]=data[i][k];
                    /*if(data[i][j]=="" 
                        //&& data.length>1 
                        && (!($("#chkGuardarvacias").is(":checked"))) 
                        ){
                        //Poner en amarillo si no tiene contenido
                        $('td#'+j+'-'+i).css("background-color","#ff0");
                        celdasvacias=true;
                        cantidadceldasrenglon++;
                    }*/
                }
                dato=data[i][k];
            }
        //}    
        /*if(celdasvacias){
            //Las celdas vacias son las misma cantidad de celdas existentes
            if(cantidadceldasrenglon==data[i].length-1){//-1 por la columna ID que no se toma en cuenta
                for(j=1;j<data[i].length;j++){
                    //Poner en blanco las celdas, por si anteriormente ya se habian marcado como vacias (amarillo)
                    $('td#'+j+'-'+i).css("background-color","#fff");
                }    
            }
            else
                renglonconceldasvacias.push(i)
        }*/
        //datos.push(row);
    //}
        
    //return datos;
    return dato;
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