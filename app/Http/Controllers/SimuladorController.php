<?php

/**
 * Este archivo forma parte del Simulador de Negocios.
 *
 * (c) Emmanuel Hernández <emmanuelhd@gmail.com>
 *
 *  Prohibida su reproducción parcial o total sin 
 *  consentimiento explícito de Integra Ideas Consultores.
 *
 *  Noviembre - 2018
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Producto, App\Catum, App\User, App\Etapa, App\Pronostico;
use Auth, View, Session, Lang, Route;


class SimuladorController extends Controller
{
	/* =================================================
	 *                Variables globales 
	 * =================================================*/

	/* Ancho de las columnas */
	protected $colWidths = [ 220, 200, 80, 100, 200, 150 ];

	/* Cabeceras de las columnas */
	protected $colHeaders =[
				'Ingredientes',
				'Cantidad (según tu receta <br>para elaborar el producto)',
				'Unidad',
				'Precio <br> por unidad',
				'Precio unitario (precio de lista <br>del proveedor)',
				'Costo por ingrediente',
			 ];
	/* Tipo de datos y formato de columnas */
	protected $columns = '[
			{ "type": "text"},
			{ "type": "numeric" },
			{ "type": "numeric" },
			{ "type": "text", "mask": "0,000,000.00", "options":{"reverse": true } },
			{ "type": "text", "mask": "0,000,000.00", "options":{"reverse": true } },
			{ "type": "text", "mask": "0,000,000.00", "options":{"reverse": true } }
		]';

	/** 
	 * ==================================================================== 
	 * Función para mostrar el inicio del simulador, el usuario debe estar
	 * logeado y haber seleccionado un producto para iniciar el simulador
	 * 
	 * @author Emmanuel Hernández Díaz
	 * ====================================================================
	*/
	public function inicio(Request $request)
	{
		/* El usuario debe estar loggeado */
		if ( Auth::check() ){
			/* El usuario debe tener un producto seleccionado */
			if ( Session::get('prodSeleccionado') == null ){
				return redirect('/home');
			} else {
				/* Obtengo el avance que lleva el usuario para saber que vista mostrar 
				 * default - Inicio
				 * 1 - Pronostico de ventas
				 * 2 - Inventario
				*/
				$avance = obtenAvance(Auth::user() ->id, Session::get('prodSeleccionado')->id);
				switch ($avance) {
					case 1:
						return view('simulador.simulador.pronosticoVentas');
						break;
					case 2:
						$pronostico = Pronostico::where('id_user', Auth::user() -> id)
												->where('id_producto', Session::get('prodSeleccionado.id'))
												->first();
						$costoUnitario = obtenCostoUnitario(Session::get('prodSeleccionado.id'));
						Session::put('pronostico', $pronostico);
						Session::put('costoUnitario', $costoUnitario);
						return view('simulador.inventario.index');
					return;
					default:
						return view('simulador.simulador.inicio');
						break;
				}
			}
		} else { return view('auth.login'); }
	}

	/** 
	 * ==============================================================
	 * Función para regresar el primer formato de jExcel, columnas, 
	 * cabeceras y formato de filas.
	 * ==============================================================
	*/
	public function getData(Request $request)
	{
		/* Compruebo que no se haya hecho el calculo con anterioridad
		 * para evitar que se agreguen datos duplicados en jExcel  */
		$msg  = Session::get('PBBDData');
		if ( $msg != null ) 
		{
			/* Obtener los datos guardados en sesion */
			$data            = $msg;
			$cols            = $this -> colHeaders;
			$graphicData     = $this -> getGraphicData(Session::get('PBBD'));
			$datosCalculados = true;
		} else {
			/* Data por deafult, mientras el simulador está en pruebas*/
			$data = [
				[ "Ingredientes por platillo para 5 comidas", 5, 1, 53,52.80],
				[ "Mano de Obra", 6, 1, 53,52.80],
				[ "Empaque/Presentación", 7, 1, 53,52.80],
			];
			/* Al ser la primer vista aún no se muestra la columna costo por ingrediente y se elimina del arrelo */
			$cols            = $this -> colHeaders;
			unset($cols[count($cols)-1]);
			$graphicData     = null;
			$datosCalculados = false;
		}
		/* Inserto la variable en la sesion, puede ser true o false*/
		Session::put('datosCalculados', $datosCalculados);

		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'               => 'success',
			'data'                 => $data,
			'colHeaders'           => $cols,
			'colWidths'            => $this -> colWidths,
			'columns'              => $this -> columns,
			'allowManualInsertRow' => false,
			'allowInsertColumn'    => false,
			'allowDeleteColumn'    => false,
			'allowDeleteRow'       => false,
			'msg'                  => $msg, /* Eliminar esta variable despues de las pruebas*/
			'datosCalculados'      => $datosCalculados,
			'graphicData'          => $graphicData,
		]);
	}

	/** 
	 * ==============================================================
	 * Función para calcular el precio de venta de cada ingrediente
	 * que el usuario capturó en jExcel.
	 * 
	 * @author Emmanuel Hernández Díaz
	 * ==============================================================
	*/
	public function calcularPrecioVenta(Request $request)
	{
		/* Mensajes personalizados cuando hay errores en la validación */
		$messages = [
			'required' => 'El campo es obligatorio',
			'numeric'  => 'El valor debe ser numérico',
			'between'  => 'El valor de PBBD debe estar entre 1 y 99',
		];

		/* Reglas de validacion */
		$rules = [
			'jExcel' => ['required'],
			'PBBD'   => ['required','numeric','between:1,99']
		];

		/* Se validan los datos con las reglas y mensajes especificados */
		$validate = \Validator::make($request -> all(), $rules, $messages);

		/* Si la validación falla, regreso solamente el primer error. */
		if ($validate -> fails())
		{
			return response()->json([
				'status' => 'error',
				'msg'    => $validate -> errors() -> first()]);
		}

		/* Guardo los datos enviados por el usuario en las variables */
		$jExcel = $request -> jExcel;
		$PBBD   = $request -> PBBD;

		/* Obtengo el largo del arreglo */
		$largo = count($jExcel);

		/* Suma de todos los Costos de Ingredientes */
		$sumCI = 0;

		/* Calculo el costo del ingrediente (Cantidad/Unidad * Precio Unitario) */
		for ($i=0;$i<$largo;$i++)
		{
			$costoIng      = $jExcel[$i][1] * substr($jExcel[$i][4],2);

			/* Guardo la suma de todos los costos por ingredientes */
			$sumCI += $costoIng;

			/* Guardo en la posición 5 el nuevo valor */
			$jExcel[$i][5] = '$ '. number_format($costoIng, 2, '.', ',');
		}
		
		/* Agrego una variable a la sesión para saber que ya se hizo el calculo */
		Session::put('PBBDData', $jExcel);

		/* Variable para conservar el valor de Beneficio Bruto Deseado y mostrarlo en la vista */ 
		Session::put('PBBD', $PBBD);

		/* Calculo el costo unitario, antes de convertir a cadena sumCI */
		$porcionPersona  = Session::get('prodSeleccionado') -> porcionpersona;
		$unidadMedida    = Session::get('prodSeleccionado') -> catum -> idesc;
		$costoUnitario   = $sumCI / $porcionPersona;
		$costoPrimoVenta = 100 - $PBBD;

		/* Calculo el precio de venta */
		$precioVenta     = number_format((100*$costoUnitario) / $costoPrimoVenta, 2, '.', ',');
		Session::put('precioVenta', $precioVenta);

		/* Variable para guardar la suma de todos los costos de ingredientes formato $ 0,000.00*/
		$sumCI ='$ '.number_format($sumCI, 2, '.', ',');

		/* Guardo la suma de todos los costos de ingredientes ne la sesion */
		Session::put('sumCI', $sumCI);

		/* Variable para guardar el costo uniario => Costo por ingrediente/porciones */
		$costoUnitario = '$ '.number_format($costoUnitario, 2, '.', ',');
		Session::put('costoUnitario', $costoUnitario);

		/* Guardo si los datos han sido calculados o no */
		Session::put('datosCalculados', true);

		$graphicData = $this -> getGraphicData($PBBD);

		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'               => 'success',
			'msg'                  => Lang::get('messages.calculoExitoso'),
			'columns'              => $this -> columns,
			'colWidths'            => $this -> colWidths,
			'colHeaders'           => $this -> colHeaders,
			'data'                 => $jExcel,
			'sumCI'                => $sumCI,
			'porcionpersona'       => $porcionPersona.' '.$unidadMedida,
			'costoUnitario'        => $costoUnitario,
			'datosCalculados'      => true,
			'allowManualInsertRow' => false,
			'allowInsertColumn'    => false,
			'allowDeleteColumn'    => false,
			'allowDeleteRow'       => false,
			'graphicData'          => $graphicData,
			'precioVenta'          => $precioVenta
		]);
	}
	/** 
	 * ==============================================================
	 * Función para obtener los datos que se van a mostrar en la
	 * gráfica.
	 * 
	 * @author Emmanuel Hernández Díaz
	 * ==============================================================
	*/
	public function getGraphicData($PBDD)
	{
		$costoPrimoVenta = 100 - $PBDD;
		$graphicData     = '[
			{"label":"'.Lang::get('messages.PBBB').'","data":'.$PBDD.',"color":"#E91E63"  },
			{"label":"'.Lang::get('messages.costoPV').'","data":'.$costoPrimoVenta.',"color":"#FFC107"  }
		]';
		return $graphicData;
	}

	public function siguiente(Request $request)
	{
		/* EL id indica que vista se va a dibujar*/
		$id_siguiente = $request -> id;
		if ( $id_siguiente == 2 ){
			/* La segunda vista es el Pronostico de ventas*/
			if($request -> ajax()){
				$id_producto     = Session::get('prodSeleccionado') -> id;
				$id_user         = Auth::user() -> id;
				$data            = Session::get('PBBDData');
				$dataPrecioVenta = [
					"totalCostosPrimos" => Session::get('sumCI'),
					"costoUnitario"     => Session::get('costoUnitario'),
					"precioVenta"       => Session::get('precioVenta'),
				];
				$dataPrecioVenta = json_encode($dataPrecioVenta);
				$PBBD            = Session::get('PBBD');
				$datosGuardados = guardarCosteo($id_user, $id_producto, $data, $PBBD, $dataPrecioVenta);
				/* Verifico que no haya errores al guardar los datos del costeo */
				if ( $datosGuardados == "true"){
					/* Si no hay errores agrego la etapa como completa */
					$etapa = terminarEtapa($id_user, $id_producto, 1);
				} else {
					return response() -> json(['status' => 'error', 'message' => $datosGuardados], 500);
				}
				return response() -> json(["message" => "ok"],200); 
			} else {
				return $view;
			} 
		}
	}
}
