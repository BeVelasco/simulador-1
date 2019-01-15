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


class NominaController extends Controller
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
			/*if ( Session::get('prodSeleccionado') == null )
			{
				return redirect('/productomenu');
			} else {*/
			     return view('/simulador/nomina/inicio');
			/*}*/
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
	public function get_nomina(Request $request)
	{
        
        /* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
        
        $formulas=Array(
                ["=D[x]*E[x]","F"],
            	["=F[x]*12","G"],
            	["=F[x]/30.4*6*0.25","H"],
            	["=F[x]/30.4*15","I"],
            	["=G[x]+H[x]+I[x]","J"],
            	["=J[x]*0.25","K"],
            	["=J[x]*0.05","L"],
            	["=J[x]*0.02","M"],
            	["=K[x]+L[x]+M[x]","N"],
            	["=J[x]+N[x]","O"]);
        /* Formulación */
        $sql='SELECT t.id,t.`sueldode`,t.`sueldoa`,t.`salariopagar`,t.`numerotrabajadores`
            	            	,"=D[x]*E[x]" AS `salariototalmes`
            	,"=F[x]*12" AS `salariototalantes`
            	,"=F[x]/30.4*6*0.25" AS `primavacacional`
            	,"=F[x]/30.4*15" AS `aguinaldoanual`
            	,"=G[x]+H[x]+I[x]" AS `salariototaldesp`
            	,"=J[x]*0.25" AS `seguridadsocial`
            	,"=J[x]*0.05" AS `fondonacional`
            	,"=J[x]*0.02" AS `ahorroretiro`
            	,"=K[x]+L[x]+M[x]" AS `totalimpuestos`
            	,"=J[x]+N[x]" AS `totalimporte`
            FROM nominas AS t
            WHERE t.`id_user`=:id_usuario';

        $res = DB::select($sql, ['id_usuario'=>$idUser]);
        //Pasarlo a forma de array de puros valores [[][]...]
        $datanomina=Array();
        if(count($res)>0){
            for($i=0;$i<count($res);$i++){
                $row=Array();
                foreach ($res[$i] as $key => $value){
                    if(in_array($key, ["salariototalmes","salariototalanual","primavacacional"
                            ,"aguinaldoanual","salariototaldesp","seguridadsocial","fondonacional","ahorroretiro"
                            ,"totalimpuestos","totalimporte"]))
                        $value=str_replace("[x]",$i+1,$value);
                    $row[]=$value;
                }
                $datanomina[]=$row;
            }
        }
        

		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'        => 'success',
			'datanomina'    => $datanomina,
            'formulas'      => $formulas

		]);
	}
}