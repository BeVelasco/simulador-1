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

use Illuminate\Http\Request, App\Producto, App\Catum, App\User, App\Etapa, App\Pronostico, Auth, View, Session, Lang, Route, Reloader;


class SimuladorController extends Controller
{
	/* =================================================
	 *                Variables globales
	 * =================================================*/

	/* Ancho de las columnas */
	protected $colWidths = '';

	/* Cabeceras de las columnas */
	protected $colHeaders ='';
	/* Tipo de datos y formato de columnas */
	protected $columns = '';

	/**
	 * ====================================================================
	 * Función para mostrar el inicio del simulador, el usuario debe estar
	 * logeado y haber seleccionado un producto para iniciar el simulador
	 *
	 * @author Emmanuel Hernández Díaz
	 * ====================================================================
	*/
	public function inicio(Request $request){
		$idProducto = Session::get('prodSeleccionado');
		if ($idProducto == null){ Session::flash('error', Lang::get('messages.debeSelProd'));return redirect('/home');
		} else {
			$avance = Reloader::getAvance(Auth::user()->id, $idProducto);
			switch ($avance) {
				case 1:return view('simulador.simulador.pronosticoVentas');break;
				case 2:
					$pronostico = Reloader::getPronostico(Auth::user() -> id, $idProducto);
					if ($pronostico == null){$request->session()->flash('error', Lang::get('messages.sinPronostico'));return redirect('home');}
					$costoUnitario = Reloader::getCostoUnitario($idProducto);
					Session::put('pronostico', $pronostico);
					Session::put('costoUnitario', $costoUnitario);
					return view('simulador.inventario.index');
				return;
				case 3:return view('simulador.mercadotecnia.index');break;
				case 4:return ('Siguiente vista muchacho');
				default:return view('simulador.simulador.inicio');break;
			}
		}
	}
	public function getData(Request $request){
		$msg  = Session::get('PBBDData');
		if ( $msg != null ) {
			$data            = $msg;
			$cols            = $this -> colHeaders;
			$graphicData     = $this -> getGraphicData(Session::get('PBBD'));
			$datosCalculados = true;
		} else {
			/* Data por deafult, mientras el simulador está en pruebas*/
			$data = [
				/*[ "Ingredientes por platillo para 5 comidas", 5, 1, 53,52.80],
				[ "Mano de Obra", 6, 1, 53,52.80],
				[ "Empaque/Presentación", 7, 1, 53,52.80],*/
			];
            // añadir las formulas
            for($i=0;$i<count($data);$i++){
                $data[$i][5]="=B".($i+1)."/C".($i+1)."*E".($i+1)."";
            }

			/* Al ser la primer vista aún no se muestra la columna costo por ingrediente y se elimina del arrelo */
			$cols            = $this -> colHeaders;
			//unset($cols[count($cols)-1]);

			$graphicData     = null;
			$datosCalculados = false;
		}
		Session::put('datosCalculados', $datosCalculados);
		return response() -> json([
			'status'               => 'success',
			'data'                 => $data,
			'colHeaders'           => $cols,
			'colWidths'            => $this -> colWidths,
			'columns'              => $this -> columns,
			'msg'                  => $msg, /* Eliminar esta variable despues de las pruebas*/
			'datosCalculados'      => $datosCalculados,
			'graphicData'          => $graphicData,
		]);}

	public function calcularPrecioVenta(Request $request){
		$jExcel = $request -> jExcel;
		$PBBD   = $request -> PBBD;
		$largo = count($jExcel);
		$sumCI = 0;
		/* Calculo el costo del ingrediente (Cantidad/Unidad * Precio Unitario) */
		for ($i=0;$i<$largo;$i++){
			$costoIng      = substr($jExcel[$i][5],2); //$jExcel[$i][1] * substr($jExcel[$i][4],2);
			/* Guardo la suma de todos los costos por ingredientes */
			$sumCI += $costoIng;
			/* Guardo en la posición 5 el nuevo valor */
			//$jExcel[$i][5] = '$ '. number_format($costoIng, 2, '.', ',');
		}
		/* Agrego una variable a la sesión para saber que ya se hizo el calculo */
		Session::put('PBBDData', $jExcel);

		/* Variable para conservar el valor de Beneficio Bruto Deseado y mostrarlo en la vista */
		Session::put('PBBD', $PBBD);
		$porcionPersona  = producto(Session::get('prodSeleccionado'),'porcionpersona');
		$unidadMedida    = catum(producto(Session::get('prodSeleccionado'),'idcatnum1'), 'idesc');
		$costoUnitario   = $sumCI / $porcionPersona;
		$costoPrimoVenta = 100 - $PBBD;
		$precioVenta     = number_format((100*$costoUnitario) / $costoPrimoVenta, 2, '.', ',');
		Session::put('precioVenta', $precioVenta);
		$sumCI = number_format($sumCI, 2, '.', ',');
		Session::put('sumCI', $sumCI);
		$costoUnitario = '$ '.number_format($costoUnitario, 2, '.', ',');
		Session::put('costoUnitario', $costoUnitario);
		Session::put('datosCalculados', true);
		$graphicData = $this -> getGraphicData($PBBD);
		return response() -> json([
			'status'               => 'success',
			'msg'                  => Lang::get('messages.calculoExitoso'),
			/*'columns'              => $this -> columns,
			'colWidths'            => $this -> colWidths,
			'colHeaders'           => $this -> colHeaders,
			'data'                 => $jExcel,*/
			'sumCI'                => $sumCI,
			'porcionpersona'       => $porcionPersona.' '.$unidadMedida,
			'costoUnitario'        => $costoUnitario,
			'datosCalculados'      => true,
			'graphicData'          => $graphicData,
			'precioVenta'          => $precioVenta
		]);
	}
	public function getGraphicData($PBDD){
		$costoPrimoVenta = 100 - $PBDD;
		$graphicData     = '[{"label":"'.Lang::get('messages.PBBB').'","data":'.$PBDD.',"color":"#E91E63" },{"label":"'.Lang::get('messages.costoPV').'","data":'.$costoPrimoVenta.',"color":"#FFC107"}]';
		return $graphicData;
	}

	public function siguiente(Request $request){
		$id_siguiente = $request -> id;
		if ( $id_siguiente == 2 ){
			if($request -> ajax()){
				$id_producto     = Session::get('prodSeleccionado');
				$id_user         = Auth::user() -> id;
				$data            = Session::get('PBBDData');
				$dataPrecioVenta = ["totalCostosPrimos"=>Session::get('sumCI'),"costoUnitario"=>Session::get('costoUnitario'),"precioVenta"=>Session::get('precioVenta'),];
				$dataPrecioVenta = json_encode($dataPrecioVenta);
				$PBBD            = Session::get('PBBD');
				$datosGuardados = guardarCosteo($id_user, $id_producto, $data, $PBBD, $dataPrecioVenta);
				if ( $datosGuardados == "true"){$etapa = terminarEtapa($id_user, $id_producto, 1);}
				else { return response() -> json(['status' => 'error', 'message' => $datosGuardados], 500); }
				return response() -> json(["message" => "ok"],200);
			} else { return $view; }
		}
	}
}
