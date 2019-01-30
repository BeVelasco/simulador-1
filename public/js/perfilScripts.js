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
		url     : '/usuario/get_perfil',
		type    : 'POST',
		dataType: 'JSON',
		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
		success : function (data) { 
		  
			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
			if (data['status'] == 'success')
			{
			     $("input[name='name']").val(data.data[0]["name"]);
                 $("input[name='email']").val(data.data[0]["email"]);
			     $("input[name='avatar'][value='"+data.data[0]["avatar"]+"']").prop('checked', true);
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
 * Función para guardar los datos
 * @author JAVG
 * ======================================================================
 */
function Guardar(){
    	$.ajax({
    		url     : '/usuario/set_perfil',
            data    :{
                        "name":$("input[name='name']").val()
                        ,"email":$("input[name='email']").val()
                        ,"avatar":$("input[name='avatar']:checked").val()
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
    					onClose: () => {
								/* Cierra el modal de crear categoría y limpia los inputs*/
								$("#imgAvatar").attr("src","../img/adminTemplate/"+$("input[name='avatar']:checked").val()+".png");
                                $(".profile-info .name").text($("input[name='name']").val())
							}
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


/**=========================================================================
 * Regresar al menu de productos
 * =========================================================================
 */
function regresar(){
    window.location.href = "/home";
}