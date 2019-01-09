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
use Illuminate\Support\Facades\DB;

use App\Producto, App\Catum, App\User, App\Etapa;
use Auth, View, Session, Lang, Route;


class ProductoController extends Controller
{
	/* =================================================
	 *                Variables globales 
	 * =================================================*/

	/* Ancho de las columnas */
	protected $colWidths = [ 1,220, 50, 50, 150, 90, 90, 90, 1, 1, 1, 90, 90, 90, 90, 90, 90 ];

	/* Cabeceras de las columnas */
	protected $colHeaders =[
                'ID',
				'Insumos',
				'Unidad',
				'Piezas',
				'Unidad de<br>medida',
				'Costo',
				'Piezas x<br>unidad',
                'Unidades<br>hechas con<br>esa pieza',
                'P1',
                'P2',
                'P3',
                'Total<br>producción',
                'Piezas<br>Servicios',
                'Costo<br>Servicios',
                'Total<br>Servicios',
                'Total',
                'Tiempo<br> en surtir',
			 ];
	/* Tipo de datos y formato de columnas */
	protected $columns = '[
            { "type": "hidden"},
			{ "type": "text"},
			{ "type": "text"},
			{ "type": "text"},
            { "type": "text" },
            { "type": "numeric"},
            { "type": "numeric"}, 
            
            { "type": "numeric" },
            { "type": "numeric"},
            
            { "type": "numeric" },
            
            { "type": "numeric"},
            { "type": "numeric" }
		]';
    public function index()
	{
		/* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
        
        
        /* Obtener los datos de la BD */
        $sql='SELECT p.`id`,p.`idesc`,c.`idesc` AS descum,p.`porcionpersona`,p.created_at
            	,CASE p.state WHEN "A" THEN "activo"
            	END AS state
            	,CASE p.state WHEN "A" THEN "green"
            	END AS colorstate
            FROM `productos` AS p
            	LEFT JOIN `catums` AS c ON p.`idcatnum1`=c.`id`
            WHERE id_user_r=:id_usuario';

        $res = DB::select($sql, ['id_usuario'=>$idUser]);
        
		/* Return the view withe some needed variables */
		return view('/simulador/producto/productomenu',[
			'productos'     => $res,
            'noProductos'   => count($res),
		]);
	}
	/** 
	 * ==================================================================== 
	 * Función para mostrar la vista de editar producto
     * $request->id=>producto
	 * 
	 * @author Jaime Vázquez
	 * ====================================================================
	*/
	public function editarProducto(Request $request)
	{
		/* Mensajes personalizados cuando hay errores en la validación */
		$messages = [
			'exists'   => 'El :attribute no existe.',
			'required' => 'El campo :attribute es obligatorio.',
		];

		/* Reglas de validacion */
		$rules = [
			'id' => ['required','exists:productos,id'],
		];

		/* Se validan los datos con las reglas y mensajes especificados */
		$validate = \Validator::make($request->all(), $rules, $messages);

		/* Si la validación falla, regreso solamente el primer error. */
		if ($validate -> fails())
		{
			return response()->json([
				'status' => 'error',
				'msg'    => $validate->errors()->first()]);
		}

		/* Verifica que el usuario esté logeado y coincida con el id que envió*/
		$idProd   = $request -> id;
		$error    = ['status' => 'error','msg' => 'Datos no coinciden.'];
		$producto = Producto::find($idProd);

		if ( Auth::check() )
		{
			if (  $producto -> id_user_r == Auth::user() -> id )
			{
				/* Agrego a la sesión los datos del producto seleccionado */
				Session::put('prodSeleccionado', $producto);
				return response()->json([
					'status' => 'success',
					'msg'    => 'Correcto']);
			} else {
				/* El producto no es de el*/
				return response()->json([$error]);
			}
		} else { 
			/* Usuario no está logeado o los datos no coinciden*/
			return response()->json([$error]);
		}
	}

	/** 
	 * ==============================================================
	 * Función para regresar el primer formato de jExcel, columnas, 
	 * cabeceras y formato de filas.
	 * ==============================================================
	*/
	public function get_producto(Request $request)
	{
		/* Inserto la variable en la sesion, puede ser true o false*/
		$id_producto=Session::get('prodSeleccionado')->id;
        
        /* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
        
        
        /* Obtener los datos de la BD */
        $sql='SELECT pin.`id`,pin.`insumo`,pin.`unidad`,pin.`piezas`,pin.`um`,pin.`costo`
                ,"=IF(H[x]>0,D[x]/H[x],D[x])" AS `piezasxunidad`
                ,pin.`unidadesconesapieza`
                ,"=IF(AND(H[x]<=0.9,M[x]<=1),F[x]*H[x],0)" AS `prodx1`
                ,"=IF(AND(H[x]>=1,M[x]<=1),F[x]/H[x],0)" AS `prodx2`
                ,"=IF(AND(H[x]<=0,M[x]<=0),D[x]*F[x],0)" AS `prodx3`
            	,"=IF(M[x]<=0,(I[x]+J[x]+K[x]),0)" AS `totalproduccion`
                ,pin.`piezaser`
                ,pin.`costoser`
                ,"=IF(M[x]>=1,M[x]*O[x],0)" AS `totalser`
                ,"=(L[x]+O[x])*C[x]" AS `total`
                
            FROM `productos` AS p
            	LEFT JOIN `productosinsumos` AS pin ON p.`id`=pin.`id_productos`
            WHERE p.`id_user_r`=:id_usuario AND p.`id`=:id_producto';

        $res = DB::select($sql, ['id_usuario'=>$idUser,'id_producto'=>$id_producto]);
        //Pasarlo a forma de array de puros valores [[][]...]
        $data=Array();
        if(count($res)>0){
            for($i=0;$i<count($res);$i++){
                $row=Array();
                foreach ($res[$i] as $key => $value){
                    if(in_array($key, ["piezasxunidad","prodx1","prodx2","prodx3","totalproduccion","totalser","total"]))
                        $value=str_replace("[x]",$i+1,$value);
                    $row[]=$value;
                }
                $data[]=$row;
            }
            //Totales
            $row=Array("TOTALES","TOTALES","","","","","","","","","","=SUM(L1:L".count($res).")","","","","=SUM(P1:P".count($res).")","");
            $data[]=$row;
        }
        
		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'               => 'success',
			'data'                 => $data,
			'colHeaders'           => $this -> colHeaders,
			'colWidths'            => $this -> colWidths,
			'columns'              => $this -> columns,
			'allowManualInsertRow' => false,
			'allowInsertColumn'    => false,
			'allowDeleteColumn'    => false,
			'allowDeleteRow'       => false,

		]);
	}

	/** 
	 * ==============================================================
	 * Función para calcular el precio de venta de cada ingrediente
	 * que el usuario capturó en jExcel.
	 * 
	 * @author Jaime Vázquez
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
	 * @author Jaime Vázquez
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
			$view = View::make('simulador.simulador.pronosticoVentas');
			if($request -> ajax()){
				$sections        = $view->renderSections();
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
				return response() -> json($sections['content']); 
			} else {
				return $view;
			} 
		}
	}
}
