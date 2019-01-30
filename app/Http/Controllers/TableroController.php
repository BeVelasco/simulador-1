<?php

/**
 * Este archivo forma parte del Simulador de Negocios.
 *
 * (c) Emmanuel HernÃ¡ndez <emmanuelhd@gmail.com>
 *
 *  Prohibida su reproducciÃ³n parcial o total sin 
 *  consentimiento explÃ­cito de Integra Ideas Consultores.
 *
 *  Noviembre - 2018
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth, View, Session, Lang, Route;


class TableroController extends Controller
{
	/* =================================================
	 *                Variables globales 
	 * =================================================*/
    
    /** 
	 * ==================================================================== 
	 * FunciÃ³n para verificar que se tenga seleccionado el producto al inicio de la ediciÃ³n
	 * 
	 * @author Jaime VÃ¡zquez
	 * ====================================================================
	*/
	public function inicio(Request $request)
	{
		/* El usuario debe estar loggeado */
		if ( Auth::check() )
		{
            return view('/simulador/dashboard/inicio');//return view('/noticias');
		} else {
			return view('auth.login');
		}
	}
    
    /** 
	 * ==============================================================
	 * FunciÃ³n para regresar los datos.
	 * ==============================================================
	*/
	public function get_productos(Request $request)
	{
        
        /* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
        
        
        /* FormulaciÃ³n */
        $sql='
            SELECT 0 AS id,"General" AS idesc
            	,valpos_char(@d:=avance_total(:id_usuario,0),1,";") AS porcentaje
            	,valpos_char(@d,2,";") AS jsontext
            UNION ALL
            SELECT p.`id`,p.`idesc`
                ,valpos_char(@d:=avance_total(:id_usuario,p.id),1,";") AS porcentaje
	           ,valpos_char(@d,2,";") AS jsontext
            FROM `productos` AS p
            WHERE p.`deleted_at` IS NULL
            	AND p.`id_user_r`=:id_usuario';
    
                
        $res = DB::select($sql, ['id_usuario'=>$idUser]);
        
		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'         => 'success',
			'data'           => $res,
		]);
	}
    
    /** ==============================================================
	 * FunciÃ³n para duardar los datos.
	 * ==============================================================
     */
	public function set_formulacion(Request $request)
	{
        $input = $request->except(['_token']);
		
		/* Obtiene el id del usuario */
		$idUser = Auth::user() -> id;
        
        $id_producto=Session::get('prodSeleccionado');
        
        try{
			$existe = Tktformula::where('id_user', $idUser)
				->where('id_productos', $id_producto)
				->first();
			if ( $existe == null ){
			     /* Se agregan los valores enviados por el usuario y se guarda en la BD */
        		$tktformula   = new Tktformula();
                
                $tktformula["id_user"]=$idUser;
                $tktformula["id_productos"]=$id_producto;
                $tktformula["procesos"]=json_encode($request["datos"]);
                $tktformula["sumatakttime"]=$request["sumatakttime"];
        		$tktformula -> save();
			} else {
				/* Si encuentra coincidencia solo actualiza el valor de realizado */
				$existe["procesos"]=json_encode($request["datos"]);
                $existe["sumatakttime"]=$request["sumatakttime"];
				$existe -> save();
			}			
		}
		catch (Exception $e) { return $e->getMessage();	}

		

		/* Regreso la respuesta exitosa con el total para actualizar el nÃºmero en la vista  */
		return response() -> json([
			'status'  => 'success',
			'msg'     => 'Información guardada con éxito.',
		]);
	}
}