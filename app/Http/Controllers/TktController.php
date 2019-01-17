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


class TktController extends Controller
{
	/* =================================================
	 *                Variables globales 
	 * =================================================*/
    
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
			     return view('/simulador/tkt/tkt');
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
	public function get_formulacion(Request $request)
	{
		/* Inserto la variable en la sesion, puede ser true o false*/
		$id_producto=Session::get('prodSeleccionado')->id;
        
        /* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
        
        
        /* Formulación */
        $sql='SELECT t.id,t.proceso,t.tiempo,t.cantidad,t.insumos,t.personas,t.maquinaria,t.herramienta
            	,t.check1,t.check2,t.check3,t.check4,t.check5
                ,"=AVG(I[x]:M[x])" AS `promedio`
            FROM productos AS p
            	LEFT JOIN `tktformulas` AS t ON p.`id`=t.id_productos
            WHERE p.`id_user_r`=:id_usuario AND p.`id`=:id_producto';

        $res = DB::select($sql, ['id_usuario'=>$idUser,'id_producto'=>$id_producto]);
        //Pasarlo a forma de array de puros valores [[][]...]
        $dataformulacion=Array();
        if(count($res)>0){
            for($i=0;$i<count($res);$i++){
                $row=Array();
                foreach ($res[$i] as $key => $value){
                    if(in_array($key, ["promedio"]))
                        $value=str_replace("[x]",$i+1,$value);
                    $row[]=$value;
                }
                $dataformulacion[]=$row;
            }
        }
        
        /* Tiempo */
        $sql='SELECT t.id,t.proceso,t.tiempo,t.cantidad,t.insumos,t.personas,t.maquinaria,t.herramienta
            	,t.check1,t.check2,t.check3,t.check4,t.check5
                ,"=AVG(I[x]:M[x])" AS `promedio`
            FROM productos AS p
            	LEFT JOIN `tktformulas` AS t ON p.`id`=t.id_productos
            WHERE p.`id_user_r`=:id_usuario AND p.`id`=:id_producto';

        $res = DB::select($sql, ['id_usuario'=>$idUser,'id_producto'=>$id_producto]);
        //Pasarlo a forma de array de puros valores [[][]...]
        $dataformulacion=Array();
        if(count($res)>0){
            for($i=0;$i<count($res);$i++){
                $row=Array();
                foreach ($res[$i] as $key => $value){
                    if(in_array($key, ["promedio"]))
                        $value=str_replace("[x]",$i+1,$value);
                    $row[]=$value;
                }
                $dataformulacion[]=$row;
            }
        }
        
		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'               => 'success',
			'formulacion'                 => $dataformulacion,

		]);
	}
}