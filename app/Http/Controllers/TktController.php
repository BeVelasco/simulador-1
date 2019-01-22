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

use App\Tktformula;
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
	 * Función para regresar los datos.
	 * ==============================================================
	*/
	public function get_formulacion(Request $request)
	{
		/* Inserto la variable en la sesion, puede ser true o false*/
		$id_producto=Session::get('prodSeleccionado');
        
        /* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
        
        
        /* Formulación */
        $sql='SELECT t.procesos,t.sumatakttime
            FROM productos AS p
            	LEFT JOIN `tktformulas` AS t ON p.`id`=t.id_productos
            WHERE p.`id_user_r`=:id_usuario AND p.`id`=:id_producto';
    
                
        $res = DB::select($sql, ['id_usuario'=>$idUser,'id_producto'=>$id_producto]);
        //Pasarlo a forma de array de puros valores [[][]...]
        $dataformulacion=Array();
        //dd($res);
        if(count($res)>0 && $res[0]->procesos!=null){
            $dataformulacion=json_decode($res[0]->procesos);
            $sumatakttime=$res[0]->sumatakttime;
            
            for($i=0;$i<count($dataformulacion);$i++){
                $dataformulacion[$i][12]="=AVG(H".($i+1).":L".($i+1).")";
            }
        }
        else{
            $sumatakttime=0;
            $dataformulacion=Array(Array("","","","","","","","","","","","","=AVG(H1:L1)"));    
        }
        
            
        /*for($i=0;$i<count($res);$i++){
            $row=Array();
            foreach ($res[$i] as $key => $value){
                if(in_array($key, ["promedio"]))
                    $value=str_replace("[x]",$i+1,$value);
                $row[]=$value;
            }
            $dataformulacion[]=$row;
        }*/
        
        
        
        
		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'         => 'success',
			'formulacion'    => $dataformulacion,
            'sumatakttime'   => $sumatakttime
		]);
	}
    
    /** ==============================================================
	 * Función para duardar los datos.
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

		

		/* Regreso la respuesta exitosa con el total para actualizar el número en la vista  */
		return response() -> json([
			'status'  => 'success',
			'msg'     => 'Información guardada con exito.',
		]);
	}
}