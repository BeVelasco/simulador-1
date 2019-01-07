/**======================================================================
 * Función que carga jExcel con algunos datos por default y los formatea
 * @author Emmanuel Hernández Díaz
 * ======================================================================
 */
	var globales={
		'poblacionNeta'    : 0,
		'mercadoPotencial' : 0,
		'mercadoDisponible': 0,
		'capCompUsar'      : 0,
		'capAbaMerc'       : 0,
		'sinCalculo'       : $('meta[name="sinCalculo"]').attr('content'),
		'tasaCrecPob'      : 0,
		'tasaCrecVen'      : 0,
		'consumoAnual'     : 0,
		'pregunta'         : $('meta[name="pregunta"]').attr('content'),
		'porcentajeAnual'  : 0,
		'unidades'         : [],
		'total'            : [],
		'costoUnitario'    : [],
	};
	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),}});
$(document).ready(function(){
	/* =====================================================================
	 * Acciones por defualt, solo en prubeas, eliminiar despues de terminar
	 * =====================================================================
	 */
	var personas      = 6168000;
	var porcObje      = 30;
	var pobNeta       = (personas*porcObje)/100;
	$('#txtEstado').focus();
	$('#txtEstado').val('Puebla');
	$('#txtPersonas').focus();
	$('#txtPersonas').val(personas);
	$('#txtCiudadObjetivo').val('Puebla');
	$('#txtCiudadObjetivo').focus();
	$('#txtPorcentaje').focus();
	$('#txtPorcentaje').val(porcObje);
	$('#txtPerCiuObj').focus();
	$('#txtPerCiuObj').val(pobNeta);
	$('#txtPerCiuObj').prop('disabled', true);
	$('#txtEstado').focus();
	/* =====================================================================
	 * Finalizan acciones de prueba
	 * =====================================================================
	*/
});

/* Función para pasar a la siguiente vista presionando Enter*/
function checaEnter(e,vista){
    var keynum;
    if ( window.event ) keynum = e.keyCode;
    if ( e.which ) keynum = e.which;
	if (vista == 1) { calcularRegionObjetivo(); } else { if (keynum === 13) { showVista(vista); } }
}

/* Función que calcula el total de personas en la region objetivo, pregunta
 * que segmentación usará el usuario y la pinta en pantalla */
function calcularRegionObjetivo()
{
	/* Bloqueo el acceso a los siguientes tabs cuando se calcula de nuevo y borro su contenido de todos los tabs */
	$('.li-pronostico').each(function () { $(this).removeAttr("data-toggle"); });
	$('.contenidosPronostico').each(function(){ $(this).empty(); });
	/* Verifico que la forma sea válida */
	if($("#formPV1")[0].checkValidity()) 
	{
		var personas = $('#txtPersonas').val(), porcentaje = $('#txtPorcentaje').val();
		if (personas > 0 && porcentaje > 0)
		{
			$.ajax({
				url     : '/simulador/regionObjetivo',
				type    : 'POST',
				dataType: 'JSON',
				data    :{
					estado        : $('#txtEstado').val(),
					ciudadObjetivo: $('#txtCiudadObjetivo').val(),
					personas      : personas,
					porcentaje    : porcentaje,
				},
				success : function (data) { 
					$('#txtPerCiuObj').val(data.totalPersonas);
					/* Si todo es correcto pregutno que segementación usará */
					(async function f() {
						const {value: segmentacion} = await Swal({
							title            : data.message + ' ' + data.totalPersonas.toLocaleString('en'),
							text             : data.text,
							input            : 'select',
							allowOutsideClick: false,
							allowEscapeKey   : false,
							inputOptions     : {
								'pea': data.pea,
								'spg': data.spg,
								'spe': data.spe,
							},
							inputPlaceholder: data.seleccioneMetodo,
							showCancelButton: false,
							inputValidator  : (value) => {
								return new Promise((resolve) => {
									if (value === '') {
										resolve(data.tieneSelVal);
									} else {
										resolve();
									}
								});
							}
						});
						if (segmentacion) {
							/* Mando a pedir la vista de la segmentación renderizada para pintarla en el HTML */
							$.ajax({
								url     : '/simulador/getSegmentacion',
								type    : 'POST',
								dataType: 'JSON',
								data:{ segmentacion: segmentacion },
								success : function (data1){
									$('#contenidoSegmentacion').empty();
									$('#contenidoSegmentacion').append(data1.segmentacion);
									document.getElementById("liSegementacion").setAttribute("data-toggle", "tab");
									document.getElementById("liSegementacion").click();
									globales.segmentacion = segmentacion;
								},
								error: function(data1){
									muestraAlertaError(data1.responseJSON.message);
								}
							});
						}
					})()
				},
				error : function (data) { muestraAlertaError(data.responseJSON.message); },
			});
		}
	} else {
		$("#formPV1")[0].reportValidity();
	}
}
/** =========================================================================
 * Funcion para que impide insertar un valor > 100 y < 0, muestra los datos*
 * en tiempo real en la pantalla y calcula el total de perosnsas para el   *
 * los 3 tipos de segmentación                                             *
 *                                                                         *
 * @param  Object  $a  [Text input]                                        *
 * @param  Integer $id [id del text input]                                 *
 *==========================================================================
 */
function sumaSeg(a, id)
{
	/* Impide que el valor sea menor a 0 y mayor a 100 */
	if ( (a.value > 100) || (a.value<0) ) a.value = '';
	/* Obtengo el porcentaje introducido por el usuario */
	var porc = a.value;
	/* Obtengo el total de personas dependiendo del porcentaje */
	var val  = Math.round((porc * $('#txtPerCiuObj').val())/100);
	/* Cambio el valor del input dependiendo su Id */
	switch (id){
		/* 1 y 2 PEC */
		case 1:
			/* Lo formateo: 123,456 personas */
			$('#txtTotalPorcPobEcoAct').val(redondear(val) + ' personas');
			/* Guardo el valor en campo oculto */
			$('#val1').val(val);
		break;
		case 2:
			/* Lo formateo: 123,456 personas */
			$('#txtTotalImpactoRegional').val(redondear(val) + ' personas');
			/* Guardo el valor en campo oculto */
			$('#val2').val(val);
		break;
		/* 3 y 4 SPG */
		case 3:
			/* Lo formateo: 123,456 personas */
			$('#txtTotal1').val(Intl.NumberFormat().format(val) +' personas');
			/* Guardo el valor en campo oculto */
			$('#val1').val(val);
		break;
		case 4:
			/* Lo formateo: 123,456 personas */
			$('#txtTotal2').val(Intl.NumberFormat().format(val) +' personas');
			/* Guardo el valor en campo oculto */
			$('#val2').val(val);
		break;
		/* 5 SPE */
		case 5:
			var totalHombres = 0, totalMujeres = 0;
			for (i = 1; i < 10; i++) { 
				val           = ($('#txtPerCiuObj').val() * $('#txtSpeHombres'+i).val()) /100;
				totalHombres += val;
				$('#txtTotalSpeHombres'+i).val(redondear(val) +' personas');
			}
			for (i = 10; i < 19; i++) { 
				val           = ($('#txtPerCiuObj').val() * $('#txtSpeMujeres'+i).val()) /100;
				totalMujeres += val;
				$('#txtTotalSpeMujeres'+i).val(redondear(val) +' personas');
			}
			$('#divTotalhombres').html( 'Total Hombres: '+ redondear(totalHombres) );
			$('#divTotalmujeres').html( 'Total Mujeres: '+ redondear(totalMujeres) );
			$('#val1').val(totalHombres);
			$('#val2').val(totalMujeres);
		break;
	}
	/* Sumo el % de la ciudad + otros estados*/
	a = Number($('#val1').val())+Number($('#val2').val());
	globales.poblacionNeta = a;
	/* Lo pinto en pantalla */
	$('#poblacionNeta').html(redondear(a)) ; 
}

/* Función que hace la suma de los niveles socioeconomicos*/
function sumaNse(a, id)
{
	/* El valor debe estar entre 0 y 100, si no, se borra */ 
	if ((a.value > 100) || (a.value < 0)) a.value = '';
	var totalNse = Math.round((globales.poblacionNeta * a.value) / 100), sum = 0;
	/* Muestro el valor calculado en el input de total */
	$('#txtTotalNse'+id).val(redondear(totalNse) + ' personsas');
	/* Calculo la suma de todos los inputs */
	$(".txtTotalNse").each(function (index) {
		sum += Math.round((Number($('#txtNse' + (index+1)).val()) * globales.poblacionNeta) / 100);
	});
	/* Guardo la suma en las variables globales */
	globales.mercadoPotencial = sum;
	/* Pinto el total en el HTML */
	$('#totalPoblacionNse').html(redondear(sum) + ' personas');
}

function calculaMercDisp(a)
{
	if ( (a.value > 100) || (a.value<0) ) 
	{
		a.value = null;
		ocultaMuestraPaneles('oculta',1);
		return;
	}
	globales.mercadoDisponible = (a.value * globales.mercadoPotencial) / 100;
	$('#labelMercDisp').html(redondear(globales.mercadoDisponible) + ' ');
	if (globales.mercadoDisponible > 0) { ocultaMuestraPaneles('muestra',1); } else { ocultaMuestraPaneles('oculta',1); }
	calculaCapComProd(document.getElementById('txtCapComProd'));
}

function calculaCapComProd(a)
{
	var valor = a.value;
	if ( (valor > 100) || (valor < 0) ) 
	{
		a.value = null;
		ocultaMuestraPaneles('oculta',2);
		return;
	}
	globales.capCompUsar = ( a.value * globales.mercadoDisponible ) / 100;
	$('#labelCapComProd').html( redondear(globales.capCompUsar) + ' ');
	if ( globales.capCompUsar > 0 ) { ocultaMuestraPaneles('muestra',2); } else { ocultaMuestraPaneles('oculta',2); }
	calculaCapAbaMerc(document.getElementById('txtCapAbaMerc'));
}

function calculaCapAbaMerc(a)
{
	if ((a.value > 100) || (a.value < 0)) {a.value = null; return;}
	globales.capAbaMerc = (a.value * globales.capCompUsar) / 100;
	$('#labelCapAbaMerc').html(redondear(globales.capAbaMerc) + ' ');
	if (globales.capAbaMerc > 0 ) { ocultaMuestraPaneles('muestra', 3); } else { ocultaMuestraPaneles('oculta', 3); }
}

function calcularConsumoAnual(a)
{
	if ( a.value < 0 ) { a.value = null; return; }
	globales.consumoAnual = (a.value * globales.capAbaMerc);
	$('#labeluniConsPot').html( redondear(globales.consumoAnual) + ' ');
}
/**
 * Función que muestra u oculta los paneles de la vista de Mercados
 * Var accion String ['muestra', 'oculta']
 * Var nivel  Integer
*/
function ocultaMuestraPaneles(accion, nivel){
	switch (accion){
		case 'oculta':
			switch ( nivel ){
				case 1:
					$('#divCapComProd').css('visibility', 'hidden');
					$('#divCapAbaMerc').css('visibility', 'hidden');
					$('#txtCapComProd').val('0');
					$('#labelCapComProd').html('0 ');
				break;
				case 2:
					$('#divCapAbaMerc').css('visibility', 'hidden');
					$('#divUniRazCon').css('visibility', 'hidden');
				break;
				case 3:
					$('#divUniRazCon').css('visibility', 'hidden');
				break;
			}
			$('#labelCapAbaMerc').html('0 ');
			$('#txtCapAbaMerc').val('0');
		break;

		case 'muestra':
			if (nivel == 1) {$('#divCapComProd').css('visibility', 'visible');}
			if (nivel == 2) {$('#divCapAbaMerc').css('visibility', 'visible');}
			if (nivel == 3) {$('#divUniRazCon').css('visibility', 'visible');}
		break;
	}
}

function showVista(vista) {
	var variables = [];
	switch (vista){
		case 'ProyVen':
			if (globales.consumoAnual <= 0){ muestraAlertaError(globales.sinCalculo); return; }
			variables = {
				intUsarProd   : Number($("#txtIntProd").val()),
				capUsarComProd: Number($("#txtCapComProd").val()),
				capAbaMerc    : Number($("#txtCapAbaMerc").val()),
				uniConsPot    : Number($("#txtuniConsPot").val()),
			};
		break;
		case 'EstimDem':
			if (globales.mercadoPotencial <= 0){ muestraAlertaError(globales.sinCalculo); return; }
			var nse = [];
			$(".classTxtNse").each(function(index){
				nse[index] = Number($(this).val());
			});
			variables = {
				nse : nse,
			}
		break;
		case 'NivelSocioEco':
			if (globales.poblacionNeta <= 0){ muestraAlertaError(globales.sinCalculo); return; }
			/* Mando las variables que insertó el usuario */
			switch (globales.segmentacion) {
				case "pea":
					variables = {
						porcPobEcoAct  : Number($("#txtPorcPobEcoAct").val()),
						impactoRegional: Number($("#txtImpactoRegional").val()),
					};
				break;
				case 'spg':
					variables = {
						hombresEcoAct: Number($("#txtHombresEcoAct").val()),
						mujeresEcoAct: Number($("#txtMujeresEcoAct").val()),
					};
				break;
				case 'spe':
					var hombres = [], mujeres = [];
					$(".classTxtSpeHombres").each(function(index){	
						hombres[index] = Number($(this).val());
					});
					$(".classTxtSpeMujeres").each(function (index) {
						mujeres[index] = Number($(this).val());
					});
					variables ={
						hombres: hombres,
						mujeres: mujeres
					};
				break;
			}
		break;
		default: return;
	}

	$.ajax({
		url     : '/simulador/getVista',
		type    : 'POST',
		dataType: 'JSON',
		data    : { 
			vista    : vista,
			variables: variables,
			seg      : globales.segmentacion,
		},
		success : function (data) {
			document.getElementById(data.li).setAttribute("data-toggle", "tab");
			document.getElementById(data.li).click();
			$(data.panel).empty();
			$(data.panel).append(data.vista);
			if (vista == 'ProyVen') llenaVistaProyVent(data.var);
		},
		error: function (data){ muestraAlertaError(data.responseJSON.message); }
	});
}

/* Funcion que muestra una alerta de error en el mensaje enviado */
function muestraAlertaError(a){ swal({type:'error',title:'Simulador',text:a}); }

function llenaVistaProyVent(year){
	year = parseInt(year.actual);
	$("#spanYear").text(" "+year+" - "+(year+1));
	$('#spanYearUno').text(year);
	$('#spanYearDos').text(year+1);
	$('#spanYearTres').text(year+2);
	$('#spanYearCuatro').text(year+3);
	/* Spans mercado potencial */
	mp = parseInt(globales.mercadoPotencial);
	$('#spanspanMercPot1').text(mp);
}

function calcularProyVen(a){
	if ( a.val <= 0 ) a.value = 0;
	globales.tasaCrecPob = $('#txttasaCrePob').value;
	globales.tasaCrecVen = $('#txttasaCreVen').value;
}

function validarInput(input){
	if( $('#'+input.id)[0].checkValidity() ) {
		globales[input.id] = 1;
	} else {
		globales[input.id] = 0;
		$('#'+input.id)[0].reportValidity();
		$('#btnProVen').attr('disabled','disabled');
		return;
	}
	valido = globales.txttasaCreVen + globales.txttasaCrePob;
	if (valido == 2) $('#btnProVen').removeAttr('disabled');	
}

function hacerProyeccion()
{
	$.ajax({
		url     : '/simulador/getProyeccion',
		type    : 'POST',
		dataType: 'JSON',
		data    : {
			creVen   : $('#txttasaCreVen').val(),
			crePob   : $('#txttasaCrePob').val(),
			variables: globales,
		},
		success : function (data) {
			$('#divProyAnual').css('visibility', 'visible');
			$('#spanMercPot1').html(redondear(data.var[0][1]));
			for ( i=1;i<5;i++ )
			{
				$('#spanMercPot'+i).html( redondear(data.var[i-1][1]) );
				$('#spanMercDisp'+i).html( redondear(data.var[i-1][2]) );
				$('#spanMercEfec'+i).html( redondear(data.var[i-1][3]) );
				$('#spanMercObje'+i).html( redondear(data.var[i-1][4]) );
				$('#spanConsAnu'+i).html( redondear(data.var[i-1][5]) );
			}
			var anio = parseInt(data.year);
			$('#spanYear1').html(anio);
			$('#spanYear2').html(anio+1);
			$('#spanYear3').html(anio+2);
			$('#spanYear4').html(anio+3);
			globales.meses = data.meses;
			globales.precioVenta = JSON.parse(data.precioVenta);
			$(".spanPrecioVenta").each(function() {
				$(this).html('$ '+ globales.precioVenta.precioVenta);
			});
			sumaVentasMensuales();//Eliminar despues de pruebas
		},
		error: function (data){	muestraAlertaError(data.responseJSON.message); }
	});
}

async function calcVentasAn1 () {
	const {value: mes} = await Swal({
		type             : 'question',
		title            : 'Simulador',
		input            : 'select',
		inputOptions     : globales.meses,
		inputPlaceholder : globales.pregunta,
		showCancelButton : false,
		allowOutsideClick: false,
		inputValidator   : (value) => {
			return new Promise((resolve) => {
				if ( value === '' ) { resolve('Debe seleccionar un mes'); } else { resolve(); }
			});
		}
	});
	$.ajax({
		url     : '/simulador/getMeses',
		type    : 'POST',
		dataType: 'JSON',
		data    : {mesInicio: mes},
		success : function (data) {
			$('#divVentasMensuales').css('visibility', 'visible');
			$(".spanMes").each(function(index) {
				$(this).html(data.meses[index+1]);
			});
		},
		error: function (data){ muestraAlertaError(data.responseJSON.message); }
	});
}

function sumaVentasMensuales()
{
	/* Variable para la suma de los inputs y forzar 2 decimales*/
	var estilo = {minimumFractionDigits: 2,maximumFractionDigits: 2};
	/* Variables de las sumas 0=Porcentaje, 1=Unidades, 2=Totla, 3=Costo Unitario */
	var sumas = {0:0,1:0,2:0,3:0};
	/* Si no tiene valor no hace nada, si tiene algo lo suma */	
	$(".classInputPorcentaje").each(function() { if ($(this).val() != '') sumas[0] += parseFloat($(this).val()); });

	$(".spanUnidad").each(function(index) {
		i2 = index+1;
		/* Obtengo y guardo el porcentaje */
		globales.unidades[i2] = ($('#inputPorcentaje' + i2).val() * globales.consumoAnual) / 100;
		/* Inserto el procentaje en el HTML */
		$(this).html(globales.unidades[i2].toLocaleString('en', estilo));
		/* Obtengo el total y lo guardo */
		globales.total[i2] = globales.unidades[i2] * globales.precioVenta.precioVenta;
		/* Inserto el total en el HTML */
		$('#spanTotal' + i2).html('$ ' + globales.total[i2].toLocaleString('en', estilo));
		/* Obtengo el costo unitario y lo muesto en el HTML*/
		globales.costoUnitario[i2] = globales.precioVenta.costoUnitario.replace('$ ', '') * parseFloat($("#spanUnidad" + (i2)).text());
		$('#spanCostoUnitario' + i2).html('$ ' + globales.costoUnitario[index + 1].toLocaleString('en', estilo));
		/* Obtengo las sumas para mostrarlas al final de la tabla */
		if (globales.unidades[i2] != '') sumas[1]      += parseFloat(globales.unidades[i2]);
		if (globales.total[i2] != '') sumas[2]         += parseFloat(globales.total[i2]);
		if (globales.costoUnitario[i2] != '') sumas[3] += parseFloat(globales.costoUnitario[i2]);
	});
	/* Si la suma sobrepasa el 100% -> rojo, si no -> negro*/
	if ( (sumas[0] > 100) || (sumas[0]<100) ){color = "red";} else { color = "#4CAF50";}
	/* Se applica el estilo */
	$(".claseSuma").each(function(ind){
		$(this).css("color", color);
		$(this).empty();$(this);
		$(this).append(sumas[ind].toLocaleString('en', estilo));
	});
}
/* Funcion que redondea un número */
function redondear(num){
	num = Intl.NumberFormat().format(Math.round(num));
	return num;
}