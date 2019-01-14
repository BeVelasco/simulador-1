<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth, View, Lang, Session, URL;
class PronosticoVentasController extends Controller
{
	/* Mensajes personalizados cuando hay errores en la validación */
	private $messages = [
				'required' => 'El campo :attribute es obligatorio',
				'numeric'  => 'El valor de :attribute debe ser numérico',
				'between'  => 'El valor de :attribute debe estar entre 1 y 99',
			];

	private $meses = [1  => 'Enero',2  => 'Febrero',3  => 'Marzo',4  => 'Abril',5  => 'Mayo',6  => 'Junio',
		7  => 'Julio',8  => 'Agosto',9  => 'Septiembre',10 => 'Octubre',11 => 'Noviembre',12 => 'Diciembre',
	];

	/**
	 * Función que calcula el total de personas en la región objetivo, si todo es 
	 * correcto guarda en la variable "regionObjetivo" de la sesión todos los datos.
	 * 
	 * @param $request Request [estado, personas, ciudadObjetivo, porcentaje]
	 * @return response;
	 */
	public function regionObjetivo(Request $request){
		if ( Auth::check() ){
			/* Reglas de validacion */
			$rules = [
				'estado'         => ['required'],
				'personas'       => ['required', 'numeric'],
				'ciudadObjetivo' => ['required'],
				'porcentaje'     => ['required','numeric','between:1,100'],
			];
			/* Nombres de los atributos */
			$atributos = [
				'estado'         => Lang::get('messages.estado'),
				'personas'       => Lang::get('messgaes.personas'),
				'ciudadObjetivo' => Lang::get('messages.ciudadObj'),
				'porcentaje'     => Lang::get('messages.porcentaje')
			];
			/* Se validan los datos con las reglas y mensajes especificados */
			$validate = \Validator::make($request -> all(), $rules, $this -> messages);
			$validate -> setAttributeNames($atributos);
			/* Si la validación falla, regreso solamente el primer error. */
			if ($validate -> fails()){ return response()->json([ 'message' => $validate -> errors() -> first()], 400); }

			$totalPersonas = ($request -> personas * $request -> porcentaje)/100;
			/* Guarda en la sesión Todos los datos de Región Objetivo */
			$regionObjetivo = [
				"estado"         => $request -> estado,
				"personas"       => $request -> personas,
				"ciudadObjetivo" => $request -> ciudadObjetivo,
				"porcentaje"     => $request -> porcentaje,
				"totalPersonas"  => $totalPersonas,
			];
			Session::put('regionObjetivo', $regionObjetivo);
			/* Regreso la respuesta con los 3 tipos de segmentación*/
			return response()->json([
				'message'          => Lang::get('messages.numTotalPersonas'),
				'text'             => Lang::get('messages.metodoUsa'),
				'pea'              => Lang::get('messages.pea'),
				'spg'              => Lang::get('messages.spg'),
				'spe'              => Lang::get('messages.spe'),
				'seleccioneMetodo' => Lang::get('messages.seleccioneMetodo'),
				'tieneSelVal'      => Lang::get('messgaes.tieneSelVal'),
				'totalPersonas'    => $totalPersonas
			], 200);
		} else { return response() -> json(['message' => 'No autorizado'], 403); }
	}

	/**
	 * Función que regresa la vista de la segmentación que escogió el usuario
	 * 
	 * @param $request Request [segmentacion (pea, spg o spe)]
	 *  @return response;
	 */
	public function getSegmentacion(Request $request){
		if (Auth::check()){
			/* Reglas de validacion */
			$rules = ['segmentacion' => ['required']];
			/* Nombres de los atributos */
			$atributos = ['segmentacion' => Lang::get('messages.segmentacion')];
			/* Se validan los datos con las reglas y mensajes especificados */
			$validate = \Validator::make($request -> all(), $rules, $this -> messages);
			$validate -> setAttributeNames($atributos);
			/* Si la validación falla, regreso solamente el primer error. */
			if ($validate -> fails()) return response()->json(['message'    => $validate -> errors() -> first()], 400);
			/* Dependiendo de la segmentación es la vista que se va a renderizar, si no existe se muestra un mensaje */			
			$segmentacion = $request -> segmentacion;
			switch ($segmentacion) {
				case 'pea':
					$view = 'simulador.segmentaciones.pea';
					break;				
				case 'spg':
					$view = 'simulador.segmentaciones.spg';
					break;				
				case 'spe':
					$view = 'simulador.segmentaciones.spe';
					break;
				default:
					return response()->json(['message' => Lang::get('messages.segmNoExiste')], 400);
					break;
			}
			/* Mando a renderizar la vista que se seleccionó */
			$segmentacion = obtenVista($view);
			/* Regreso la vista mediante Json para pintarla en HTML */
			return response() -> json(['segmentacion' => $segmentacion],200);
		} else { return response() -> json(['message' => 'No autorizado'], 403); }
	}

	/**
	 * [getVista Regresa la vista renderizada]
	 * @param  Request $request [JSON received data]
	 * @return [Response]       [JSON]
	 */
	public function getVista(Request $request) {
		/* Verifica que el usuario esté logeado */
		if ( Auth::check() ){
			/* El nombre de la vista es usado en el <li> y el <panel> */
			$vistaEnviada = $request -> vista;
			$var = null;
			/* Elijo que vista voy a renderizar*/
			switch ( $vistaEnviada ){
				case 'ProyVen':
					$respuesta = guardaEstimDemanda($request);
					/* Si la respuesta no es true, manda el mensaje del error */
					if ($respuesta != 'true') return response() -> json(["message" => $respuesta],400);
					$vista     = obtenVista('simulador.segmentaciones.proyeccionVenta');
					$var       = obtenYear();
				break;
				case 'EstimDem':
					/* Función que guarda en la sesión los datos de la segmentación */
					$respuesta = guardaNivelSocioEco($request, $this -> messages);
					/* Si la respuesta no es true, manda el mensaje del error */
					if ($respuesta != 'true') return response() -> json(["message" => $respuesta],400);
					$vista = obtenVista('simulador.segmentaciones.mercadoDisponible');
				break;
				case 'NivelSocioEco':
					/* Función que guarda en la sesión los datos de la segmentación */
					$respuesta = guardaSegmentacion($request, $this -> messages);
					/* Si la respuesta no es true, manda el mensaje del error */
					if ($respuesta != 'true') return response() -> json(["message" => $respuesta],400);
					/* Si todo es correcto rensderiza la siguiente vista */
					$vista = obtenVista('simulador.segmentaciones.nse');
				break;
				case 'Inventario':
					/* Guarda en la sesión la proyeccion de ventas */
					$respuesta = guardaProyeccionVentas($request);
					/* Si hubo algun error muetro un mensaje */
					if ($respuesta != 'true') return response() -> json(["message" => $respuesta],400);
					/* Guarda o Actualiza la segmentación del producto en la BD */
					$respuesta = guardaPronosticoVenta();
					/* Si hubo algun error muetro un mensaje */
					if ($respuesta != 'true') return response() -> json(["message" => $respuesta],400);
					$guardaEtapa = terminarEtapa(Auth::user()->id,Session::get('prodSeleccionado')->id, 2);
					if ($guardaEtapa == "true"){
						return response() -> json([
							//'vista' => $vista,
							'var'   => 'etapa3',
							'ruta'  => URL::route('inventario'),
						]);
					} else { return response() -> json(["message" => $guardarEtapa], 401);}
					
				break;
				default: 
					return response() -> json(['message' => Lang::get('messages.vistaNoExiste')]);
				break;
			}
			/* Creo el nombre del <li> y del <panel> */
			$li    =  'li'.$vistaEnviada;
			$panel = '#contenidopanel'.$vistaEnviada;
			/* Regreso la respuesta en JSON */
			return response() -> json([
				'vista' => $vista,
				'li'    => $li,
				'panel' => $panel,
				'var'   => $var,
			], 200);
		} else { return response() -> json(['message' => 'No autorizado'], 403); } 
	}

	/**
	 * [obtenMeses obtenMeses Obiente el listado de meses a partir del mes
	 *  que el usuario comenzará su negocio]
	 * @param  [Integer] $mesInicio [Mes de inicio del negocio entre 1 y 12]
	 * @return [Array]              [Array con la lista de meses]
	*/
	public function getMeses(Request $request)
	{
		/* El usuario debe estar logeado para iniciar esta acción */
		if ( Auth::check() ){
			/* Reglas para validar los datos recibidos */
			$rules = [
				'mesInicio' => ['required','numeric','between:1,12'],
			];
			/* Mensajes personalizados de validación */
			$mensajes = [
				'required' => 'El campo :attribute es obligatorio',
				'numeric'  => 'El valor de :attribute ser numérico',
				'between'  => 'El valor de :attribute debe estar entre 1 y 12',
			];
			/* Nombres de los atributos */
			$atributos = [
				'mesInicio' => Lang::get('messages.mesInicio'),
			];
			/* Valido los datos */
			$validate = \Validator::make($request -> all(), $rules, $mensajes);
			$validate -> setAttributeNames($atributos);
			/* Regreso error si la validación falló */
			if ($validate -> fails()){ return response()->json(['message' => $validate -> errors() -> first()], 400); }
			$mesInicio = $request -> mesInicio;
			for ( $i=1;$i<13;$i++ )
			{
				$a[$i]     = $this -> meses[$mesInicio];
				$mesInicio == 12 ? $mesInicio = 1 : $mesInicio++;
			}
			return  response() -> json(['meses' => $a], 200);
		} else return response() -> json(['message' => 'No autorizado'], 403);
	}

	public function getProyeccion(Request $request){
		$idProducto = Session::get('prodSeleccionado');
		/* El usuario debe estar logeado para iniciar esta acción */
		if ( Auth::check() ){
			/* Reglas para validar los datos recibidos */
			$rules = [
				'variables' => ['required'],
				'creVen'    => ['required', 'numeric'],
				'crePob'    => ['required', 'numeric'],
			];
			$atributos = [
				'variables' => 'variables',
				'creVen' => Lang::get('messages.tasaCreVen'),
				'crePob' => Lang::get('messages.tasaCrePob'),
			];
			/* Valido los datos */
			$validate = \Validator::make($request -> all(), $rules, $this -> messages);
			$validate -> setAttributeNames($atributos);
			/* Muestro error si la validación falló */
			if ($validate -> fails()){ return response()->json(['message' => $validate -> errors() -> first()], 400); }
			$variables = $request['variables'];
			$creVen    = $request -> creVen;
			$crePob    = $request -> crePob;
			$year      = obtenYear();
			$year      = $year['actual'];
			$proy[0]   = [
				'1' => $variables['mercadoPotencial'] * 1,
				'2' => $variables['mercadoDisponible'] * 1,
				'3' => $variables['mercadoEfectivo'] * 1,
				'4' => $variables['mercadoObjetivo'] * 1,
				'5' => $variables['consumoAnual'] * 1,
			];
			$precioVenta = obtenPrecioVenta($idProducto['id']);
			for ( $i=1;$i<4;$i++ ){
				$proy[$i] = [
					'1' => ( ( $proy[$i-1][1] * $crePob )/100) +  $proy[$i-1][1],
					'2' => ( ( $proy[$i-1][2] * $crePob )/100) +  $proy[$i-1][2],
					'3' => ( ( $proy[$i-1][3] * $crePob )/100) +  $proy[$i-1][3],
					'4' => ( ( $proy[$i-1][4] * $creVen )/100) +  $proy[$i-1][4],
					'5' => ( ( $proy[$i-1][5] * $creVen )/100) +  $proy[$i-1][5],
				];
			}
			return response() -> json ([
				'var'         => $proy,
				'year'        => $year,
				'meses'       => $this -> meses,
				'precioVenta' => $precioVenta,
			],200);
		} else { return response() -> json(['message' => 'No autorizado'], 403); } 
	}
}