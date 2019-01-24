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
	protected $colWidths = [ 220, 50, 50, 150, 90, 90, 90, 1, 1, 1, 90, 90, 90, 90, 90, 90 ];

	/* Cabeceras de las columnas */
	protected $colHeaders =[
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
	   /* El usuario debe estar loggeado */
		if ( Auth::check() )
		{
			
			/* El usuario debe tener un producto seleccionado */
			if ( Session::get('prodSeleccionado') == null )
			{
				return redirect('/home');
			} else {
			     return view('/simulador/producto/producto');
			}
		} else {
			return view('auth.login');
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
		$id_producto=Session::get('prodSeleccionado');
        
        /* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
        
        /* Productos */
        $sql='SELECT datos,totalproduccion,grantotal
            FROM `productosinsumos`
            WHERE `id_user`=:id_usuario AND `id_productos`=:id_producto';
    
                
        $res = DB::select($sql, ['id_usuario'=>$idUser,'id_producto'=>$id_producto]);
        //Pasarlo a forma de array de puros valores [[][]...]
        $data=Array();
        //dd($res);
        if(count($res)>0 && $res[0]->datos!=null){
            $data=json_decode($res[0]->datos);
            $totalproduccion=$res[0]->totalproduccion;
            $grantotal=$res[0]->grantotal;
        }
        else{
            /* Productos */
            $sql='SELECT REPLACE(data,"$","") as data
                FROM `costeoproductos`
                WHERE `id_user`=:id_usuario AND `id_producto`=:id_producto';
        
                    
            $res = DB::select($sql, ['id_usuario'=>$idUser,'id_producto'=>$id_producto]);
            //Pasarlo a forma de array de puros valores [[][]...]
            $data=json_decode($res[0]->data);
            
            $totalproduccion=0;$grantotal=0;
            for($i=0;$i<count($data);$i++){
                $grantotal+=preg_replace('/[^0-9.]+/', '', $data[$i][5]);
            }
        }
        
        //Colocar las fformulas
        for($i=0;$i<count($data);$i++){
            //Intercambiar posiciones
            $tmp=$data[$i][2];
            $data[$i][2]=$data[$i][1];
            $data[$i][1]=$tmp;
            
            $data[$i][5]="=IF(G".($i+1).">0,C".($i+1)."/G".($i+1).",C".($i+1).")";
            $data[$i][7]="=IF(AND(G".($i+1)."<=0.9,L".($i+1)."<=1),(E".($i+1)."*G".($i+1)."),0)";
            $data[$i][8]="=IF(AND(G".($i+1).">=1,L".($i+1)."<=1),E".($i+1)."/G".($i+1).",0)";
            $data[$i][9]="=IF(AND(G".($i+1)."<=0,L".($i+1)."<=0),C".($i+1)."*E".($i+1).",0)";
        	$data[$i][10]="=IF(L".($i+1)."<=0,(H".($i+1)."+I".($i+1)."+J".($i+1)."),0)";
            $data[$i][13]="=IF(L".($i+1).">=1,E".($i+1)."*L".($i+1).",0)";
            $data[$i][14]="=(K".($i+1)."+N".($i+1).")*B".($i+1)."";
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
            'totalproduccion'      =>$totalproduccion,
            'grantotal'            =>$grantotal,

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
		$id_producto=Session::get('prodSeleccionado');
        try{
			$pi = Productosinsumo::where('id_user', $idUser)
				->where('id_productos', $id_producto)
				->first();
			if ( $pi == null ){
			     /* Se agregan los valores enviados por el usuario y se guarda en la BD */
        		$pi   = new Productosinsumo();
                
                $pi["id_user"]=$idUser;
                $pi["id_productos"]=$id_producto;
                $pi["datos"]=json_encode($request["datos"]);
                
			} else {
				/* Si encuentra coincidencia solo actualiza el valor de realizado */
				$pi["datos"]=json_encode($request["datos"]);
			}
            
            $d=$request->datos;
            $pi["totalproduccion"]=0;$pi["grantotal"]=0; 
            for($i=0;$i<count($d);$i++){
                $pi["totalproduccion"]+=str_replace("$","",$d[$i][10]);
                $pi["grantotal"]+=str_replace("$","",$d[$i][14]);
            }
            $pi -> save();	
            /* Se agregan los valores enviados por el usuario y se guarda en la BD */
        }
		catch (Exception $e) { return $e->getMessage();	}

		

		/* Regreso la respuesta exitosa con el total para actualizar el número en la vista  */
		return response() -> json([
			'status'  => 'success',
			'msg'     => 'Información guardada con exito.',
		]);
	}
}
