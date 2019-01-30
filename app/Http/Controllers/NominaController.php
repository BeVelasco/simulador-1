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

use App\Producto, App\Catum, App\User, App\Etapa, App\Nomina;
use Auth, View, Session, Lang, Route;


class NominaController extends Controller
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
			     return view('/simulador/nomina/nomina');
			/*}*/
		} else {
			return view('auth.login');
		}
	}
    
    /** 
	 * ==============================================================
	 * FunciÃ³n para regresar el primer formato de jExcel, columnas, 
	 * cabeceras y formato de filas.
	 * ==============================================================
	*/
	public function get_nomina(Request $request)
	{
        
        /* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
        
        /* FormulaciÃ³n */
        $sql='SELECT t.`datos`,t.sumanomina
            FROM nominas AS t
            WHERE t.`id_user`=:id_usuario';

        $res = DB::select($sql, ['id_usuario'=>$idUser]);
        
        //Pasarlo a forma de array de puros valores [[][]...]
        if(count($res)>0 ){
            $datanomina=json_decode($res[0]->datos);
            $sumanomina=$res[0]->sumanomina;
        }
        else{
            $datanomina=Array();
            array_push($datanomina,
                Array("Director comercial","10000","160000","0","0","0","0","0","0","0","0","0","0","0","0"),
                Array("Ejecutivo comercial/gestor de cuentas","10000","54000","0","0","0","0","0","0","0","0","0","0","0","0"),
                Array("Gerente de producción","15500","140000","0","0","0","0","0","0","0","0","0","0","0","0"),
                Array("Ingeniero de producción","8700","50000","0","0","0","0","0","0","0","0","0","0","0","0"),
                Array("Operario cualificado","2200","17500","0","0","0","0","0","0","0","0","0","0","0","0"),
                Array("Operario no cualificado","1200","13000","0","0","0","0","0","0","0","0","0","0","0","0"),
                Array("Secretaria bilingüe","4000","26000","0","0","0","0","0","0","0","0","0","0","0","0"),
                Array("Administrativo contable","6700","46000","0","0","0","0","0","0","0","0","0","0","0","0"),
                Array("Salario mínimo mensual zona","3080.40","3080.40","0","0","0","0","0","0","0","0","0","0","0","0")
                );    
            $sumanomina=0;
        }
        
        //Actualizar el array con las formulas
        for($i=0;$i<count($datanomina);$i++){
                $datanomina[$i][5]="=D".($i+1)."*E".($i+1);
                $datanomina[$i][6]="=F".($i+1)."*12";
                $datanomina[$i][7]="=F".($i+1)."/30.4*6*0.25";
                $datanomina[$i][8]="=F".($i+1)."/30.4*15";
                $datanomina[$i][9]="=G".($i+1)."+H".($i+1)."+I".($i+1)."";
                $datanomina[$i][10]="=J".($i+1)."*0.25";
                $datanomina[$i][11]="=J".($i+1)."*0.05";
                $datanomina[$i][12]="=J".($i+1)."*0.02";
                $datanomina[$i][13]="=K".($i+1)."+L".($i+1)."+M".($i+1)."";
                $datanomina[$i][14]="=J".($i+1)."+N".($i+1);
                        
        }
        
        
		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'        => 'success',
			'datanomina'    => $datanomina,
            'sumanomina'    => $sumanomina
		]);
	}
    
    /** ==============================================================
	 * FunciÃ³n para duardar los datos.
	 * ==============================================================
     */
	public function set_nomina(Request $request)
	{
        $input = $request->except(['_token']);
		
		/* Obtiene el id del usuario */
		$idUser = Auth::user() -> id;

        try{
			$existe = Nomina::where('id_user', $idUser)
				->first();
			if ( $existe == null ){
			     /* Se agregan los valores enviados por el usuario y se guarda en la BD */
        		$nomina   = new Nomina();
                
                $nomina["id_user"]=$idUser;
                $nomina["datos"]=json_encode($request["datos"]);
                $nomina["sumanomina"]=preg_replace('/[^0-9.]+/', '', $request["sumanomina"]);
                
        		$nomina -> save();
			} else {
				/* Si encuentra coincidencia solo actualiza el valor de realizado */
				$existe["datos"]=json_encode($request["datos"]);
                $existe["sumanomina"]=preg_replace('/[^0-9.]+/', '', $request["sumanomina"]);
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