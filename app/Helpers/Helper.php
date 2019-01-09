<?php

use App\Etapa, App\Costeo, Carbon\Carbon;

/** 
 * =====================================================
 * Funcion que agrega a la base de datos una etapa del
 * simulador terminada para determinado usuario
 * @author Emmanuel Hernández Díaz
 * =====================================================
*/
function terminarEtapa($id_user, $id_producto, $seccion) {
	/* Verifico que el usuario esté logeado y corresponda su id */
	if ( (Auth::check()) && (Auth::user() -> id == $id_user) ){
		/* Verifico que se hayan mandado todos los datos */
		if ( ($seccion || null) && ($id_user || null) ){
			try{
				$existe = Etapa::where('seccion', $seccion)
					->where('id_user', $id_user)
					->where('id_producto', $id_producto)
					->first();
				/* Si no encuentra una coincidencia, es un nuevo avance */
				if ( $existe == null ){
					$etapa = New Etapa;
					$etapa -> seccion     = $seccion;
					$etapa -> id_user     = $id_user;
					$etapa -> realizado   = true;
					$etapa -> id_producto = $id_producto;
					$etapa -> save();
				} else {
					/* Si encuentra coincidencia solo actualiza el valor de realizado */
					$existe -> realizado = true;
					$existe -> save();
				}
			} 
			catch (Exception $e) { return $e -> getMessage(); }
			return "true";
		} else { return "Datos incompletos"; }
	} else { return "Datos erróneos"; }
}

/* Obtiene el avance del usuario */
function obtenAvance($id_user, $id_producto){
	$avance = Etapa::where('id_user', $id_user)
		-> where('id_producto', $id_producto)
		-> where('realizado', 1) 
		-> orderBy('updated_at', 'DESC')
		-> pluck('seccion')
		-> first();
	return $avance;
}

function guardarCosteo($id_user, $id_producto, $data, $PBBD, $dataPrecioVenta){
	/* Verifico que el usuario esté logeado y corresponda su id */
	if ( (Auth::check()) && (Auth::user() -> id == $id_user) ){
		/* Verifico que se hayan mandado todos los datos */
		if ( ($id_producto || null) && ($data || null) && ($PBBD || null)){
			try{
				$existe = Costeo::where('id_user', $id_user)
					->where('id_producto', $id_producto)
					->first();
				if ( $existe == null ){
					$costeo = New Costeo;
					$costeo -> id_user         = $id_user;
					$costeo -> id_producto     = $id_producto;
					$costeo -> data            = json_encode($data);
					$costeo -> PBBD            = $PBBD;
					$costeo -> dataPrecioVenta = $dataPrecioVenta;

					$costeo -> save();
				} else {
					/* Si encuentra coincidencia solo actualiza el valor de realizado */
					$existe -> data =  json_encode($data);
					$existe -> PBBD = $PBBD;
					$existe -> save();
				}			
			}
			catch (Exception $e) { return $e->getMessage();	}
			return "true";
		} else { return "Datos incompletos"; }
	} else { return "Datos erróneos"; }
}

/* Finción que obtiene el precio de venta de un producto mediante su Id */
function obtenPrecioVenta($idProducto){
	$dataPrecioVenta = Costeo::whereId_producto(4)->pluck('dataPrecioVenta');
	return $dataPrecioVenta;
}

/**
 * Función para guardar la segmentación en la sesión, guarda todos los datos que insertó el usuruario
 * solo puede ser una segmentación y todas terminan calculando la POBLACION NETA
 * 
 * @param $request Request
 * 
 */
function guardaSegmentacion($request, $messages){
    /* Obtengo el total de personas de la sesión */
    $totalPersonas = Session::get('regionObjetivo');
    $totalPersonas = $totalPersonas["totalPersonas"];
    /* Obtengo el tipo de segmentación que escogió el usuario */
    $seg = $request -> seg;
    /* Si el usuario mandó una segmentación que no existe se manda un mensaje de error */
    if ( ($seg != "pea") && ($seg != "spe") && ($seg != "spg") ) return Lang::get('messages.segNoValida');
    /* Mensajes para validar los datos enviados*/
    $rules = [
        'pea' => [
            'variables.porcPobEcoAct'   => ['required','numeric', 'between:0.00,100'],
            'variables.impactoRegional' => ['required','numeric','between:0.00,100'],
        ],
        'spg' => [
            'variables.hombresEcoAct' => ['required','numeric', 'between:0.00,100'],
            'variables.mujeresEcoAct' => ['required','numeric', 'between:0.00,100'],
        ],
        'spe' => [
            'variables' => ['required']
        ],
    ];
    /* Nombres de los campos */
    $atributos = [
        'pea' => [
            'variables.porcPobEcoAct'   => Lang::get('messages.porcentajeDe').' '.Lang::get('messages.pea'),
            'variables.impactoRegional' => Lang::get('messages.impactoOtros'),
        ],
        'spg' => [
            'variables.hombresEcoAct' => Lang::get('messages.hombresEAC'),
            'variables.mujeresEcoAct' => Lang::get('messages.mujeresEAC'),
        ],
        'spe' => [
            'variables' => 'Variables'
        ],
    ];
    /* Se validan los datos dependiendo de la segmentación */
    $validator = \Validator::make($request->all(), $rules[$seg], $messages);
    $validator -> setAttributeNames($atributos[$seg]);
    /* Si hubo algún error se regresa el mensaje para mostrarlo al usuario */ 
    if ($validator -> fails()) return $validator -> errors() -> first();
    /* Switch para guardar en la variable $segmentacion todos los datos enviado spor el usuario */
    switch ($seg) {
        /* Población económicamente activa */
        case 'pea':
            /* Calculo el total de poblacion economicamente activa y e impacto regional en otros estados */
            $totalPobEcoAct       = ($request -> variables["porcPobEcoAct"] * $totalPersonas)/100;
            $totalImpactoRegional = ($request -> variables["impactoRegional"] * $totalPersonas)/100;
            /* La Poblacion neta es la suma de los 2 totales*/
            $poblacionNeta        = $totalPobEcoAct  + $totalImpactoRegional;
            /* Guargo todos los datos en la variable segmentacion */
            $segmentacion         = [
                "tipo"                 => $seg,
                "porcPobEcoAct"        => $request -> variables["porcPobEcoAct"],
                "totalPobEcoAct"       => $totalPobEcoAct,
                "impactoRegional"      => $request -> variables["impactoRegional"],
                "totalImpactoRegional" => $totalImpactoRegional,
            ];
        break;
        /* Segmentación por género */
        case 'spg':
            /* Calculo el total de hombres y mujeres economicamente activos */
            $totalHombresEcoAct = ($request -> variables["hombresEcoAct"] * $totalPersonas)/100;
            $totalMujeresEcoAct = ($request -> variables["mujeresEcoAct"] * $totalPersonas)/100;
            /* La Poblacion neta es la suma de los 2 totales*/
            $poblacionNeta      = $totalHombresEcoAct + $totalMujeresEcoAct;
            /* Guargo todos los datos en la variable segmentacion */
            $segmentacion       = [
                "tipo"               => $seg,
                "hombresEcoAct"      => $request -> variables["hombresEcoAct"],
                "totalHombresEcoAct" => $totalHombresEcoAct,
                "mujeresEcoAct"      => $request -> variables["mujeresEcoAct"],
                "totalMujeresEcoAct" => $totalMujeresEcoAct,
            ];
        break;
        /* Segmentación por edad */
        case 'spe':
            $hombres = $request -> variables["hombres"];
            $mujeres = $request -> variables["mujeres"];
            /* Guardo lo que introdujo el usuario y su total con el siguente formato
             * hombres[0] = [1 => valIntroducido, total => Valintroducido * Total de personas */
            $poblacionNeta = 0;
            /* Compruebo que todos los valores recibidos sean numéricos */
            for ($i=0;$i<9;$i++){
                if (!is_numeric($hombres[$i])){
                    return Lang::get('messages.elValor').' '.($i+1).' de hombres '.Lang::get('messages.noNumerico');
                    break;
                }
                if (!is_numeric($mujeres[$i])){
                    return Lang::get('messages.elValor').' '.($i+1).' de mujeres '.Lang::get('messages.noNumerico');
                    break;
                }
            }
            /* Calculo el total por cada segmento y cada género y lo guardo en la variable */
            for ($i=0;$i<9;$i++){
                $aux            = ($hombres[$i] * $totalPersonas)/100;
                $poblacionNeta += $aux;
                $hombres[$i]    = [
                    $i+1    => $hombres[$i],
                    'total' => $aux
                ];
                $aux            = ($mujeres[$i] * $totalPersonas)/100;
                $poblacionNeta += $aux;
                $mujeres[$i]    = [
                    $i+1    => $mujeres[$i],
                    'total' => $aux
                ];
            }
            $segmentacion["tipo"]    = $seg;
            $segmentacion["hombres"] = $hombres;
            $segmentacion["mujeres"] = $mujeres;
        break;
        /* Si la segmentación no existe regreso un erroro */
        default:
            return Lang::get('messages.segNoValida');
        break;
    }
     /* Si la variable ya existe la elimino para evitar errores */
    if (!is_null(Session::get('segmentacion'))) Session::forget('segmentacion');
    /* Si todo salió bien, guardo en la sesión los datos y regreso true */
    $segmentacion["poblacionNeta"] = $poblacionNeta;
    Session::put('segmentacion', $segmentacion);
    return 'true';
}

/**
 * [obtenVista Obtiene la seccion content de la vista enviada]
 * @param  [string] $vista [Nombre de la vista]
 * @return [View]          [Regresa la vista renderizada]
 */
function obtenVista($vista){
    $vista = View::make($vista);
    $vista = $vista -> renderSections();
    return $vista['content'];
}

/**
 * [obtenYear Obtiene el año actual y el siguiente]
 * @return [array] [Arreglo con los 2 años]
 */
function obtenYear()
{
    $fecha     = Carbon::now()->format('Y');
    $siguiente = $fecha+3;
    $year      = [
        'actual'    => $fecha,
        'siguiente' => $siguiente,
    ];
    return $year;
}


/** Función que valida y guarda en la sesión los calculos del Nivel Socio Economico
  * @param $reques Request [Datos enviados por le usuario]
  * @return  string ['true' o 'Mensaje de error']
*/
function guardaNivelSocioEco($request, $messages){
    /* Verifico que el usuario esté logeado */
	if (Auth::check()){
        $rules     = ['variables.nse'   => 'required'];
        $atributos = ['variables.nse' => Lang::get('messages.nse')];
        /* Se validan los datos */
        $validator = \Validator::make($request->all(), $rules, $messages);
        $validator -> setAttributeNames($atributos);
        /* Si hubo algún error se regresa el mensaje para mostrarlo al usuario */ 
        if ($validator -> fails()) return $validator -> errors() -> first();
        $nse = $request -> variables["nse"];
        /* Obtengo la poblacion neta */
        $poblacionNeta = Session::get('segmentacion');
        $poblacionNeta = $poblacionNeta["poblacionNeta"];
        /* Se verifica que los valores sean numericos, si no, regresa una alerta de error*/
        $sum = 0;
        for($i=0;$i<7;$i++){
            if (!is_numeric($nse[$i])){ return Lang::get('messages.elValor').' '.($i+1).' '.Lang::get('messages.noNumerico'); }
            $aux = ($nse[$i] * $poblacionNeta)/100;
            $nivelSocioEcon[] =[
                            $i+1   => $nse[$i],
                 'totalNse'.($i+1) => $aux,
            ];
            $sum += $aux;
        }
        /* Si todo sale bien se guarda en la sesión y se regresa true */
        $nivelSocioEcon["mercadoPotencial"] = $sum;
        Session::put('NivelSocioEcon', $nivelSocioEcon);
        return "true";
    } else { return 'Datos erróneos'; }
}

function guardaEstimDemanda($request){
   /* Verifico que el usuario esté logeado */
	if (Auth::check()){
        $rules = [
            'variables.intUsarProd'    => ['required', 'numeric','between:0.01,100'],
            'variables.capUsarComProd' => ['required', 'numeric','between:0.01,100'],
            'variables.capAbaMerc'     => ['required', 'numeric','between:0.01,100'],
            'variables.uniConsPot'     => ['required', 'numeric','between:0.01,100'],
        ];
        $atributos = [
            'variables.intUsarProd'    => Lang::get('messages.interesProd'),
            'variables.capUsarComProd' => Lang::get('messages.CapComProd'),
            'variables.capAbaMerc'     => Lang::get('messages.CapAbaMerc'),
            'variables.uniConsPot'     => Lang::get('messages.uniConsPot'),
        ];
        
        return $request -> variables["intUsarProd"];
    } else { return 'Datos erróneos'; }
}