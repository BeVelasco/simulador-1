/*!

=========================================================
* Scripts para Mensajero de Simulador - v0.1
=========================================================

* Autor: Jaime Vázquez
* Copyright 2018
* Integra Ideas Consultores

=========================================================

*/

var ajaxBlock = function() { $.blockUI({message: 'Procesando...'}) }
$(document).ajaxStart(ajaxBlock).ajaxStop($.unblockUI);

$(function () {
    $(".msg-recibidos").on("click",function(){
        fill_table($(this).attr("data-tipo"));
    })
    
    fill_table("I");
    
});

function fill_table(modo){
    $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
    
    $.ajax({
            data:{
                tipo:modo//Inbox
            },
            url: '/mensajero/get_datos',
            type:'post',  
            dataType: "json",              
            success: function(data){
                
                var headers=Array();
                for(k=0;k<data.headers.length;k++){
                    headers.push({title:data.headers[k]});
                }
                
                var datos=Array()
                /*for(k=0;k<data.data.length;k++){
                    var row=Array();
                    for(i=0;i<headers.length;i++){
                        if(i<headers.length){ //Quitar la ultima columna que trae el autonumerico
                                row.push(data.data[k][headers[i].data]);
                        }
                    }
                    datos.push(row);
                } */
                var datos=Object.keys(data.data).map(function(k){
                        return Object.keys(data.data[k]).map(function(i){
                                return data.data[k][i];
                        })
                })
                if ($.fn.DataTable.isDataTable( '#tablaresultado' ) ) {
                    $('#tablaresultado').DataTable().destroy();
                    $("#divResultado").empty();
                }
                var tabla=$('<table id="tablaresultado" class="table table-striped table-bordered dataTable no-footer" role="grid" style="width: 100%;">');
                $("#divResultado").append(tabla)
                //if ( ! $.fn.DataTable.isDataTable( '#tablaresultado' ) ) {
                    /****** datatable manage ********/
                    tabla.DataTable( {
                        dom: 'Bfrtip',
                        scrollY: 300,
                        scrollX: true,
                        fixedHeader: true,
                        paging:false,
                        searching: false,          
                        language: {
                            "url": "plugins/jquery-datatable/plugins/spanish.json",
                        },
                        columns: headers,
                        data: datos,
                        buttons: [
                            //'selectNone',
                            {
                                text:      '<i class=\"material-icons action-nuevo\">add_circle</i><p class="text-icons-action">Nuevo</p>',
                                titleAttr: 'Nuevo',
                                action: function ( e, dt, node, config ) {
                                    $('#addMensaje').modal('show');                    
                                }
                            },
                            {
                                text:      '<i class=\"material-icons action-nuevo\">archive</i><p class="text-icons-action">Archivar</p>',
                                titleAttr: 'Archivar',
                                action: function ( e, dt, node, config ) {
                                }
                            },
                        ]                                    
                    } );
                    
            }
     });
}

/*Funcion para agregar un mensaje nuevo*/
function addMensaje() {
		/* Agrego el campo csrf a la cabecera de Ajax */
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		/* Mando los datos introducidos por el usuario */
		$.ajax({
			url: '/mensajero/addMensaje',
			type: 'POST',
			data: $("#form-mensaje").serialize(),
			dataType: 'JSON',
			/* Si no hay errores regresa SUCCESS, inclusi si existen errores de validación y/o de BD */
			success: function (data) { 
				/* Informa al usuario que el nuevo producto ha sido creado */
				if (data['status'] == 'success')
				{
					swal({
						type : 'success',
						title: data.msg,
						/* Cuando se cierra el modal limpia los campos y seleccion la primer opcion del select */
						onClose: () => {
							$("#cerrarProd").click();
							$("#descProd").val('');
							$("#porcion").val('');
							document.getElementById("noProd").innerHTML = data.totProd;
							/* Llamo a la funci´´on que agrega el producto nuevo a la tabla*/
							agregarProductoTable(data.totProd, data.desc, data.porcion, data.idProd, data.idUser, data.url);
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
				console.log(data);
			}
		}); 
}
