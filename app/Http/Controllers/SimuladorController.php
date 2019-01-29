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
	protected $colWidths = [ 220, 200, 80, 100, 200, 150 ];
	protected $colHeaders =['Ingredientes','Cantidad (según tu receta <br>para elaborar el producto)','Unidad','Precio <br> por unidad','Precio unitario (precio de lista <br>del proveedor)','Costo por ingrediente',];
	protected $columns = '[{ "type": "text"},{ "type": "numeric" },{ "type": "numeric" },{ "type": "text", "mask": "0,000,000.00", "options":{"reverse": true } },{ "type": "text", "mask": "0,000,000.00", "options":{"reverse": true } },{ "type": "text", "mask": "0,000,000.00", "options":{"reverse": true } }]';

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
			$data = [[ "Ingredientes por platillo para 5 comidas", 5, 1, 53,52.80],[ "Mano de Obra", 6, 1, 53,52.80],[ "Empaque/Presentación", 7, 1, 53,52.80],];
			$cols            = $this -> colHeaders;
			unset($cols[count($cols)-1]);
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
		for ($i=0;$i<$largo;$i++){$costoIng=$jExcel[$i][1]*substr($jExcel[$i][4],2);$sumCI+=$costoIng;$jExcel[$i][5]='$ '. number_format($costoIng, 2, '.', ',');}
		Session::put('PBBDData', $jExcel);
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
			'columns'              => $this -> columns,
			'colWidths'            => $this -> colWidths,
			'colHeaders'           => $this -> colHeaders,
			'data'                 => $jExcel,
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
