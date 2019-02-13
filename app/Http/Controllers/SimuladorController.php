<?php namespace App\Http\Controllers;

/**
 * Este archivo forma parte del Simulador de Negocios.
 *
 * (c) Emmanuel Hernández <emmanuelhd@gmail.com>
 *
 *  Noviembre - 2018
 */

use Illuminate\Http\Request;
use App\Http\Requests\CalcularPrecioVentaRequest;
use App\Producto;
use App\Catum;
use App\User;
use App\Etapa;
use App\Pronostico;
use Auth;
use View;
use Session;
use Lang;
use Route;
use Simulador;


class SimuladorController extends Controller
{
	/**
	 * Muestra el inicio del simulador
	 * 
	 * @param Request $request
	 * @return void
	 */
	public function inicio(Request $request)
	{
		$idProducto = Session::get('prodSeleccionado');
		if ($idProducto == null){ Session::flash('error', Lang::get('messages.debeSelProd'));return redirect('/home');
		} else {
			$avance = Simulador::getAvance(Auth::user()->id, $idProducto);
			/* Obtengo el avance que lleva el usuario para saber que vista mostrar 
				 * default - Inicio
				 * 1 - Pronostico de ventas
				 * 2 - Inventario
				 * 3 - Mercadotecnia
				 * 4 - Insumoss
				*/
			switch ($avance) {
				case 1:return view('simulador.simulador.pronosticoVentas');break;

				case 2:
					$pronostico = Simulador::getPronostico(Auth::user()->id, $idProducto);
					if ($pronostico == null)
					{
						$request->session()->flash('error', Lang::get('messages.sinPronostico'));
						return redirect('home');
					}
					$costoUnitario = Simulador::getCostoUnitario($idProducto);
					Session::put('pronostico', $pronostico);
					Session::put('costoUnitario', $costoUnitario);
					return view('simulador.inventario.index');
				break;
				/* Mercadotecnia */
				case 3:
					return view('simulador.mercadotecnia.index');
				break;
				/* Sigueitne vista */
				case 4:
					return view('simulador.producto.producto');
				/* Inicio */
				default:
					return view('simulador.simulador.inicio');
				break;
			}
		}
	}
	public function getData(Request $request){
		$msg  = Session::get('PBBDData');
		if ( $msg != null ) {
			$data            = $msg;
			$cols            = '';
			$graphicData     = $this->getGraphicData(Session::get('PBBD'));
			$datosCalculados = true;
		} else {
			/* Data por deafult, mientras el simulador está en pruebas*/
			$data = [];
            // añadir las formulas
            for($i=0;$i<count($data);$i++){
                $data[$i][5]="=B".($i+1)."/C".($i+1)."*E".($i+1)."";
            }
			$graphicData     = null;
			$datosCalculados = false;
		}
		Session::put('datosCalculados', $datosCalculados);
		return response()->json([
			'status'          => 'success',
			'data'            => $data,
			'colHeaders'      => '',
			'colWidths'       => '',
			'columns'         => '',
			'msg'             => $msg,               /* Eliminar esta variable despues de las pruebas*/
			'datosCalculados' => $datosCalculados,
			'graphicData'     => $graphicData,
		]);}

	/**
	 * Calcula el precio de venta en base a los ingredientes.
	 *
	 * @param CalcularPrecioVentaRequest $request
	 * @return void
	 */
	public function calcularPrecioVenta(CalcularPrecioVentaRequest $request)
	{
		$jExcel   = $request->jExcel;
		$response = Simulador::checkIngredients($jExcel);
		if ($response != "true")
		{
			return $response;
		}
		$response = Simulador::notZeroIngredient($jExcel);
		if ($response != "true")
		{
			return $response;
		}
		$PBBD  = $request->PBBD;
		$sumCI = Simulador::getCI($jExcel);
		//$response = Simulador::
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
		$costoUnitario = number_format($costoUnitario, 2, '.', ',');
		Session::put('costoUnitario', $costoUnitario);
		Session::put('datosCalculados', true);
		$graphicData = $this->getGraphicData($PBBD);
		return response()->json([
			'status'          => 'success',
			'msg'             => Lang::get('messages.calculoExitoso'),
			'sumCI'           => $sumCI,
			'porcionpersona'  => $porcionPersona.' '.$unidadMedida,
			'costoUnitario'   => $costoUnitario,
			'datosCalculados' => true,
			'graphicData'     => $graphicData,
			'precioVenta'     => $precioVenta
		],200);
		/*================================================================ */
	}
	public function getGraphicData($PBDD){
		$costoPrimoVenta = 100 - $PBDD;
		$graphicData     = '[{"label":"'.Lang::get('messages.PBBB').'","data":'.$PBDD.',"color":"#E91E63" },{"label":"'.Lang::get('messages.costoPV').'","data":'.$costoPrimoVenta.',"color":"#FFC107"}]';
		return $graphicData;
	}

	public function siguiente(Request $request){
		$id_siguiente = $request->id;
		if ( $id_siguiente == 2 ){
			if($request->ajax()){
				$id_producto     = Session::get('prodSeleccionado');
				$id_user         = Auth::user()->id;
				$data            = Session::get('PBBDData');
				$dataPrecioVenta = ["totalCostosPrimos"=>Session::get('sumCI'),"costoUnitario"=>Session::get('costoUnitario'),"precioVenta"=>Session::get('precioVenta'),];
				$dataPrecioVenta = json_encode($dataPrecioVenta);
				$PBBD            = Session::get('PBBD');
				$datosGuardados  = guardarCosteo($id_user, $id_producto, $data, $PBBD, $dataPrecioVenta);
				if ( $datosGuardados == "true"){$etapa = terminarEtapa($id_user, $id_producto, 1);}
				else { return response()->json(['status' => 'error', 'message' => $datosGuardados], 500); }
				return response()->json(["message" => "ok"],200);
			} else { return $view; }
		}
	}
}
