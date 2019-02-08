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
		url     : '/reportes/get_perdidasganancias',
		type    : 'POST',
		dataType: 'JSON',
		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
		success : function (data) { 
		  
			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
			if (data['status'] == 'success')
			{
				/* Muestra jExcel con los datos recibidos */
				$("#tab-content").html(pintaReporte(data));
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

/** ============
 * 
 *  ====================
 */
function pintaReporte(data){
    
    var datos=Object.keys(data.datos).map(function(j){
        return data.datos[j]
    });
    var headers=Object.keys(data.headers).map(function(j){
        return data.headers[j]
    });
    //
    var tabla="<h3>ESTADO DE PERDIDAS Y GANANCIAS</h3>"
        +"<table id='tablapromedios' class='tablaremision table table-striped table-bordered dataTable no-footer' role='grid' style='width: 100%;'><thead><tr>";
    
    for(i=0;i<headers.length;i++)
        tabla+="<th>"+data.headers[i]["concepto"] +"</th>";
        
    tabla+="</tr></thead>";
    
    tabla +="<tbody>";
    for(i=0;i<datos.length;i++){
        var clase="";
        tabla+="<tr>";
        for(j=0;j<headers.length;j++){
            if(headers[j]["concepto"]=='concepto'){
                
                posstyle=datos[i][headers[j]["concepto"]].indexOf("<class>");
                if(posstyle>=0){
                    posstyle+=7;
                    clase=datos[i][headers[j]["concepto"]].substring(posstyle);
                    datos[i][headers[j]["concepto"]]=datos[i][headers[j]["concepto"]].substring(0,posstyle-7)
                }
                
                tabla+="<td class='"+clase+"'>"+datos[i][headers[j]["concepto"]]+"</td>"
            }
            else{
                if(clase.indexOf("vacia")>=0)
                    tabla+="<td>&nbsp;</td>"
                else
                    tabla+="<td class='"+clase+"'>"+numeral(datos[i][headers[j]["concepto"]]).format('0,0.00')+"</td>"
            }
        }
        tabla+="</tr>";
    }
    tabla+="</tbody>"
        +"</table><br/>";
    
    return tabla;
}

/**=========================================================================
 * Regresar al menu de productos
 * =========================================================================
 */
function regresar(){
    window.location.href = "/home";
}