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

use App\Producto, App\Catum, App\User, App\Etapa, App\Inversioninicial;
use Auth, View, Session, Lang, Route;


class InversioninicialController extends Controller
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
			     return view('/simulador/inicial/inversioninicial');
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
	public function get_inversion(Request $request)
	{
        
        /* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
        
        /* inventarios */
        $sqlinv='SELECT SUM(i.`valInvFinDes`) AS valInvFinDes
                FROM `inventarios` AS i
                WHERE i.`id_user`=:id_usuario';
        $resinv = DB::select($sqlinv, ['id_usuario'=>$idUser]);
        $inventario=0;
        if(count($resinv)>0){
            $inventario=$resinv[0]->valInvFinDes;
        }
        

        /* Inversión inicial */
        $sqlii='SELECT `efectivo`,`cuentasxcobrar`,`cuentasxpagar`,`impuestosxpagar`,`capitaltrabajoneto`,`equipooficina`,`plantamaquinaria`
                	,`maquinariaequipo`,`equipotransporte`,`intangibles`,`gastosconstitucion`,`gastosasesoria`,`gastospuesta`,`reclutamiento`
                	,`segurospagados`,`promocion`,`gastosinstalacion`,`papeleria`,`totalinversion`
                FROM `inversioninicials`
            WHERE `id_user`=:id_usuario';

        $res = DB::select($sqlii, ['id_usuario'=>$idUser]);
        $datainversion=Array();
        
        $i=1;$sumaactivo="";

        array_push($datainversion,Array("CAPITAL DE TRABAJO NETO","","","",""));$i++;
                //1
        array_push($datainversion,Array("+ Efectivo","0","","","efectivo"));$sumaactivo.="B".$i;$i++;
        array_push($datainversion,Array("+ Inventario",$inventario,"","",""));$sumaactivo.="+B".$i;$i++;
        array_push($datainversion,Array("+ Cuentas por cobrar","0","","","cuentasxcobrar"));$sumaactivo.="+B".$i;$i++;
        array_push($datainversion,Array("- Cuentas por pagar","0","","","cuentasxpagar"));$sumaactivo.="-B".$i;$i++;
        array_push($datainversion,Array("- Impuestos por pagar","0","","","impuestosxpagar"));$sumaactivo.="-B".$i;$i++;
        array_push($datainversion,Array("= Capital de trabajo neto","=".$sumaactivo,"=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)","0","capitaltrabajoneto"));$i++;
        array_push($datainversion,Array("","","",""));$i++;
        array_push($datainversion,Array("ACTIVOS NO CIRCULANTES","","",""));$i++;
                //9
        array_push($datainversion,Array("Equipo de oficina","0","=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)","0","equipooficina"));$i++;
        array_push($datainversion,Array("Planta y maquinaria pesada (incluye inmuebles)","0","=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)","0","plantamaquinaria"));$i++;
        array_push($datainversion,Array("Maquinaria y equipo ligero (moldes y troqueles, etc.)","0","=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)","0","maquinariaequipo"));$i++;
        array_push($datainversion,Array("Equipo de transporte","0","=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)","0","equipotransporte"));$i++;
        array_push($datainversion,Array("Intangibles","0","=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)","0","intangibles"));$i++;
        array_push($datainversion,Array("","","",""));$i++;
        array_push($datainversion,Array("OTROS ACTIVOS","","",""));$i++;
                //16
        array_push($datainversion,Array("Gastos de Constitución","0","=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)","0","gastosconstitucion"));$i++;
        array_push($datainversion,Array("Gastos de Asesoría","0","=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)","0","gastosasesoria"));$i++;
        array_push($datainversion,Array("Gastos de puesta a punto inmuebles","0","=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)","0","gastospuesta"));$i++;
        array_push($datainversion,Array("Reclutamiento","0","=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)","0","reclutamiento"));$i++;
        array_push($datainversion,Array("Seguros pagados por anticipado","0","=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)","0","segurospagados"));$i++;
        array_push($datainversion,Array("Promoción","0","=IF(OR(B".$i."<=0,D".$i."<=0),0,B21/D21*100)","0","promocion"));$i++;
        array_push($datainversion,Array("Gastos de instalación","0","=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)","0","gastosinstalacion"));$i++;
        array_push($datainversion,Array("Papelería y consumibles","0","=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)","0","papeleria"));
                
        //Pasarlo a forma de array de puros valores [[][]...]
        $totalinversion=0;
        if(count($res)>0){
            $i=0;
            //capital
            $datainversion[++$i][1]=$res[0]->efectivo;
            //$datainversion[1][1]=$inventario;
            ++$i;
            $datainversion[++$i][1]=$res[0]->cuentasxcobrar;
            $datainversion[++$i][1]=$res[0]->cuentasxpagar;
            $datainversion[++$i][1]=$res[0]->impuestosxpagar;
            
            $datainversion[++$i][1]=$res[0]->capitaltrabajoneto;
            $datainversion[$i][3]=$res[0]->totalinversion;
            
            //Activo no circulante
            ++$i;++$i;
            $datainversion[++$i][1]=$res[0]->equipooficina;
            $datainversion[$i][3]=$res[0]->totalinversion;
            
            $datainversion[++$i][1]=$res[0]->plantamaquinaria;
            $datainversion[$i][3]=$res[0]->totalinversion;
            
            $datainversion[++$i][1]=$res[0]->maquinariaequipo;
            $datainversion[$i][3]=$res[0]->totalinversion;
            
            $datainversion[++$i][1]=$res[0]->equipotransporte;
            $datainversion[$i][3]=$res[0]->totalinversion;
            
            $datainversion[++$i][1]=$res[0]->intangibles;
            $datainversion[$i][3]=$res[0]->totalinversion;
            
            //Otros activos
            ++$i;++$i;
            $datainversion[++$i][1]=$res[0]->gastosconstitucion;
            $datainversion[$i][3]=$res[0]->totalinversion;
            
            $datainversion[++$i][1]=$res[0]->gastosasesoria;
            $datainversion[$i][3]=$res[0]->totalinversion;
            
            $datainversion[++$i][1]=$res[0]->gastospuesta;
            $datainversion[$i][3]=$res[0]->totalinversion;
            
            $datainversion[++$i][1]=$res[0]->reclutamiento;
            $datainversion[$i][3]=$res[0]->totalinversion;
            
            $datainversion[++$i][1]=$res[0]->segurospagados;
            $datainversion[$i][3]=$res[0]->totalinversion;
            
            $datainversion[++$i][1]=$res[0]->promocion;
            $datainversion[$i][3]=$res[0]->totalinversion;
            
            $datainversion[++$i][1]=$res[0]->papeleria;
            $datainversion[$i][3]=$res[0]->totalinversion;
            
            $totalinversion=$res[0]->totalinversion;
        }
        else{
            $datainversion[6][3]=$totalinversion=$inventario;
        }
        
		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'        => 'success',
			'datainversion'   => $datainversion,
            'totalinversion'    => $totalinversion
		]);
	}
    
    /** ==============================================================
	 * Función para duardar los datos.
	 * ==============================================================
     */
	public function set_inversion(Request $request)
	{
        $input = $request->except(['_token']);
		
		/* Obtiene el id del usuario */
		$idUser = Auth::user() -> id;
        
    
        try{
			$obj = Inversioninicial::where('id_user', $idUser)
				->first();
			if ( $obj == null ){
			     /* Se agregan los valores enviados por el usuario y se guarda en la BD */
        		$obj   = new Inversioninicial();
                
                $obj["id_user"]=$idUser;
            }
            //Leer el json del excel
            $d=$request["datos"];
            
            for($i=0;$i<count($d);$i++){
                if($d[$i][4]!=""){//Si la columna 5 del JExcel tiene nombre de campo
                    //Llenar el arreglo segun el nombre de campo con el valor de las columna 2 del JExcel
                    $obj[$d[$i][4]]= preg_replace('/[^0-9.]+/', '', $d[$i][1]);
                }    
            }
            
            $obj["totalinversion"]=preg_replace('/[^0-9.]+/', '', $request["totalinversion"]);
    		$obj -> save();
            
		}
		catch (Exception $e) { return $e->getMessage();	}

		

		/* Regreso la respuesta exitosa con el total para actualizar el número en la vista  */
		return response() -> json([
			'status'  => 'success',
			'msg'     => 'Información guardada con exito.',
		]);
	}
}