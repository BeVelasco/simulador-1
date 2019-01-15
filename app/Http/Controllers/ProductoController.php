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

use App\Producto, App\Catum, App\User, App\Etapa, App\Productosinsumo;
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
	 * Función para seleccionar el producto y ponerlo en la sesión
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
	 * ==================================================================== 
	 * Función para verificar que se tenga seleccionado el producto al inicio de la edición
	 * 
	 * @author Jaime Vázquez
	 * ====================================================================
	*/
	public function editarInicio(Request $request)
	{
		/* El usuario debe estar loggeado */
		if ( Auth::check() )
		{
			
			/* El usuario debe tener un producto seleccionado */
			if ( Session::get('prodSeleccionado') == null )
			{
				return redirect('/productomenu');
			} else {
			     return view('/simulador/producto/producto');
			}
		} else {
			return view('auth.login');
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
	 * Guardar datos
	 * ==============================================================
	*/
	public function set_producto(Request $request)
	{
        /* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;

        /* Inserto la variable en la sesion, puede ser true o false*/
		$id_producto=Session::get('prodSeleccionado')->id;
        
        /* Se agregan los valores enviados por el usuario y se guarda en la BD */
        $d=$request->datos; 
        for($i=0;$i<count($d);$i++){
            if($d[$i][0]!="TOTALES"){
                $pi = Productosinsumo::find($d[$i][0]);
                $pi["id"]=$d[$i][0];    
                $pi["id_productos"]=$id_producto;
                $pi["insumo"]=$d[$i][1];
                $pi["unidad"]=$d[$i][2];
                $pi["piezas"]=$d[$i][3];
                $pi["um"]=$d[$i][4];
                $pi["costo"]=$d[$i][5];
                $pi["piezasxunidad"]=$d[$i][6];
                $pi["unidadesconesapieza"]=$d[$i][7];
                $pi["prodx1"]=$d[$i][8];
                $pi["prodx2"]=$d[$i][9];
                $pi["prodx3"]=$d[$i][10];
                $pi["totalproduccion"]=$d[$i][11];
                $pi["piezaser"]=$d[$i][12];
                //$pi["ventaser"]=$d[$i][13];
                $pi["costoser"]=$d[$i][13];
                $pi["totalser"]=$d[$i][14];
                $pi["total"]=$d[$i][15];
                $pi["tiempoensurtir"]=($d[$i][16]==null?0:$d[$i][16]);
                
                $pi -> save();
            }
        }

        
	}
}
