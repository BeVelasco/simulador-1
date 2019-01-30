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
		url     : '/tablero/get_productos',
		type    : 'POST',
		dataType: 'JSON',
		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
		success : function (data) { 
		  
			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
			if (data['status'] == 'success')
			{
			     $("div#tab-content").html('');
                 
                 var i=0,j=0,x=0;
                 
                 for(i=0;i<data.data.length;i++){
                    //TABS
                    $("div#simulador ul").append(
                        '<li role="presentation" ' + (i==0?'class="active"':'') + '>'
                            + '<a href="#producto'+ i +'" data-toggle="tab">'
    							+ '<div class="irs-demo">'
    								+ '<b>'+ data.data[i]["idesc"] +'</b>'
    								+ '<input type="text" id="range_'+ i +'" value="[avance'+ i +']" class="ion-range"/>'
    							+ '</div>'
    						+ '</a>'
                        + '</li>');
                    
                    //Contenedor del contenido
                    
                    $("div#tab-content").append(
                        '<div role="tabpanel" class="tab-pane fade ' + (i==0?'active in':'') + '" id="producto'+ i +'">'
                            + '<div class="col-sm-12" id="tabpanelcontent'+ i +'">'
                            + '</div>'
                        + '</div>'
                    );
                    
                    var contenido=JSON.parse(data.data[i]["jsontext"]);
                    var porcentajeprod=0;
                    for(j=0;j<contenido.length;j++){
                        
                        //Datos del timeline
                        var timelinedata=Array();
                        for(x=0;x<contenido[j]["body"]["timeline"].length;x++){
                            tlr=contenido[j]["body"]["timeline"][x];
                            
                            //timelinedata.push({date: new Date(tlr["fecha"]), title: tlr["titulo"], description: tlr["datos"]});
                            timelinedata.push({date: tlr["fecha"], title: tlr["titulo"], description: tlr["datos"]});
                        }
                        
                        //Elementos del contenido del tab
                        $('div#tabpanelcontent'+ i).append(
                            '<div class="col-sm-3">'
                                + '<a class="tablero-button" href="/home">'
        							+ '<span class="titulo">'+ contenido[j]["bloque"] +'</span>'
                                    + '<br /><br />'
                                    + '<i class="fa '+ contenido[j]["icono"] +' fa-4x"></i>'
        						+ '</a>'
        					+ '</div>'
        					+ '<div class="col-sm-3">'
        						+ '<div id="waterBall'+ i +'-'+ j +'" class="waterBall" style="width: 100px;height:100px; float:left"></div>'
        					+ '</div>'
        					+ '<div class="col-sm-6 timeline-area" style="overflow: auto;" id="timeline'+ i +'-'+ j +'">'
        						//+ '<div id="timeline'+ i +'-'+ j +'" class="timeline" style="overflow: auto;padding: 100px !important;"> </div>'
                                
        					+ '</div>'
                            + '<div class="row"></div>'
                        );
                        
                        //render_waterball
                        render_waterball('waterBall'+ i +'-'+ j,contenido[j]["body"]["porcentaje"]);
                        //timeline
                        render_timeline('timeline'+ i +'-'+ j,timelinedata);
                        
                        porcentajeprod+=parseInt(contenido[j]["body"]["porcentaje"]);
                    }
                    //Porcentaje del producto
                    porcentajeprod=Math.round(porcentajeprod/(contenido.length*100)*100);
                    $("div#simulador ul input#range_"+ i).val($("div#simulador ul input#range_"+ i).val().replace('[avance'+ i +']',porcentajeprod));
                 }
                 
                 render_ionrange();
                 
			         
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
 * Función Menu principal
 * @author Jaime Vazquez Dic 2018
 * ======================================================================
 */
 
 function render_ionrange() {
	//Taken from http://ionden.com/a/plugins/ion.rangeSlider/demo.html
	$(".ion-range").ionRangeSlider({
		skin: "modern",
		min: 0,
		max: 100,
		from_fixed: true,  // fix position of FROM handle
		to_fixed: true,
		min_interval: null,
		max_interval: null,
		onStart: function (data) {
			var id=data.input[0].id;
			var $span=data.slider[0];
			if(data.from<60){
				$($span).find(".irs-single").addClass("red");
				$($span).find(".irs-bar").addClass("red");
			}
			else if(data.from<99){
				$($span).find(".irs-single").addClass("yellow");
				$($span).find(".irs-bar").addClass("yellow");
			}
			else{
				$($span).find(".irs-single").addClass("green");
				$($span).find(".irs-bar").addClass("green");
			}					
				
		},
	});
}

function render_waterball(id,value) {

	$('#' + id).createWaterBall({
		csv_config:{
			width:$('#' + id).width(),
			height:$('#' + id).height()
		},
		wave_config:{
			waveWidth:0.02,
			waveHeight:5
		},
		data_range:[60,99,100],
		textColorRange:['#999','#fff','#fff'],
		targetRange:value
	});
}

function render_timeline(id,data){
	
    /*if(data.length>0){
    	 ultimas actividades 
    	$("#" + id).timeline({
    		data:data ,  
                [
    		{date: new Date(2018,2,12), type: "Type1", title: "Registro 1", description: "Registro de datos"},
    		{date: new Date(2018,2,15), type: "Type2", title: "Registro 2", description: "Registro de datos"},
    		{date: new Date(2018,3,5), type: "someType", title: "Registro 3", description: "Registro de datos"},
    		{date: new Date(2018,4,2), type: "someType", title: "Registro 4", description: "Registro de datos"},
    		{date: new Date(2018,4,9), type: "someType", title: "Registro 5", description: "Registro de datos"},
    		{date: new Date(2018,3,23), type: "someType", title: "Registro 6", description: "Registro de datos"},
    		{date: new Date(2018,5,20), type: "someType", title: "Registro 7", description: "Registro de datos"}
    		],
            types:  [
    		{name:"Type1", color:"#00ff00"},
    		{name:"Type2", color:"#0000ff"}
    		],
            display: "auto",
    		height: 600
    	});
     }*/
     var i=0;
     $("#" + id).append($('<div class="cd-timeline__container">'))
     for(i=0;i<data.length;i++){
        $("#" + id + " div.cd-timeline__container").append(
    		'<div class="cd-timeline__block js-cd-block">'
    			+'<div class="cd-timeline__img '+ (data[i]["date"]!=""?'cd-timeline__img--picture':'cd-timeline__img--movie') + ' js-cd-img"></div> <!-- cd-timeline__img -->'
    			+'<div class="cd-timeline__content js-cd-content">'
    				+'<h2>'+data[i]["title"]+'</h2>'
    				+'<p>'+data[i]["description"]+'</p>'
    				+'<span class="cd-timeline__date">'+data[i]["date"]+'</span>'
    			+'</div> <!-- cd-timeline__content -->'
    		+'</div> <!-- cd-timeline__block -->'
        );
     }
     
}


/* time line */
$.widget('pi.timeline', {
	options: {
		data:   [
		{date: new Date(), type:"Type1", title:"Title1", description:"Description1"},
		{date: new Date(), type:"Type2", title:"Title2", description:"Description2"}
		],
		types:  [
		{name:"Type1", color:"#00ff00"},
		{name:"Type2", color:"#0000ff"}
		],
		display: "auto",
		height: 600
	},
	_create: function(){
		this._refresh();
	},
	_refresh: function(){
		var miliConstant = 86400000
		var firstDate = this.options.data[0].date;
		var lastDate = this.options.data[0].date;
		for (i=0;i<this.options.data.length;i++) {
			if (this.options.data[i].date > lastDate) { lastDate = this.options.data[i].date; }
			else if (this.options.data[i].date < firstDate) { firstDate = this.options.data[i].date; }
		}
		var dayRange = (lastDate - firstDate) / miliConstant;
		var segSpace = Math.floor(this.options.height / (dayRange / 7));
		var segLength = 7;
		if (segSpace < 80) {
			var segSpace = Math.floor(this.options.height / (dayRange / 14));
			segLength = 14;
		}
		if (segSpace < 80) {
			var segSpace = Math.floor(this.options.height / (dayRange / 28));
			segLength = 28;
		}
		if (segSpace < 80) {
			var segSpace = Math.floor(this.options.height / (dayRange / 56));
			segLength = 56;
		}
		if (segSpace < 80) {
			var segSpace = Math.floor(this.options.height / (dayRange / 112));
			segLength = 112;
		}

		var majorCount = Math.floor(this.options.height / segSpace) + 1;

		//Empty Current Element
		this.element.empty();

		//Draw TimeLine
		this.element.append("<div class='tlLine' style='height: " + this.options.height + "px;'></div>")

		//Draw Major Markers
		var tempDate = new Date(firstDate.getTime());
		for (i=0;i<majorCount;i++) {
			this.element.append("<div class='tlMajor' style='top: " + ((segSpace * i) +7) + "px;'></div>");
			this.element.append("<span class='tlDateLabel' style='top: " + ((segSpace * i) +7) + "px;'>" +  $.datepicker.formatDate( "d M y", tempDate) + "</span>");
			tempDate.setDate(tempDate.getDate() + segLength);
		}

		//draw event markers
		for (i=0;i<this.options.data.length;i++) {
			var dayPixels = ((this.options.data[i].date - firstDate) / (lastDate - firstDate)) * this.options.height;
			//alert((this.options.data[i].date - firstDate) + ", " + (lastDate - firstDate) + ", " +dayPixels);
			this.element.append("<div class='tlDateDot' style='top: " + (dayPixels - 0) + "px;'></div>");
			this.element.append("<div class='tlEventFlag' style='height:21px; top: " + (dayPixels - 0) + "px;'>" + this.options.data[i].title + "</div>");
			this.element.append("<div class='tlEventExpand' style='top: " + (dayPixels - 0) + "px;'><p><b>" + this.options.data[i].date + "</b></p><p>" + this.options.data[i].description +  "<p></div>");
		}

		$(".tlEventExpand").hide();

		//$(".tlEventExpand").hide();
		$(".tlEventFlag").click(function(){
		var tempThis = $(this);
		$(".tlEventExpand").hide();
		$(".tlEventFlag").animate({width:'100px'}, 200);
		if (tempThis.hasClass('active')) {
			tempThis.removeClass('active');
		} else {
			$(".tlEventFlag").removeClass('active');
			tempThis.addClass('active');
			tempThis.animate({width:'120px'}, 200, function(){
				tempThis.next('div').show();
			});
		}
		});
	},
	_destroy: function() {},
	_setOptions: function() {}
});
		