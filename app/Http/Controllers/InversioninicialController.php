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

use App\Producto, App\Catum, App\User, App\Etapa, App\Inversioninicial;
use Auth, View, Session, Lang, Route;


class InversioninicialController extends Controller
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
			     return view('/simulador/inicial/inversioninicial');
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
	public function get_inversion(Request $request)
	{
        
        /* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
        
        /* inventarios */
        $sqlinv='SELECT COALESCE(SUM(i.`valInvFinDes`),0) AS valInvFinDes
                FROM `inventarios` AS i
                WHERE i.`id_user`=:id_usuario';
        $resinv = DB::select($sqlinv, ['id_usuario'=>$idUser]);
        $inventario=0;
        if(count($resinv)>0){
            $inventario=$resinv[0]->valInvFinDes;
        }
        

        /* InversiÃ³n inicial */
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
        array_push($datainversion,Array("+ Efectivo",(count($res)>0?$res[0]->efectivo:0),"","","efectivo"));$sumaactivo.="B".$i;$i++;
        array_push($datainversion,Array("+ Inventario",$inventario,"","",""));$sumaactivo.="+B".$i;$i++;
        array_push($datainversion,Array("+ Cuentas por cobrar",(count($res)>0?$res[0]->cuentasxcobrar:0),"","","cuentasxcobrar"));$sumaactivo.="+B".$i;$i++;
        array_push($datainversion,Array("- Cuentas por pagar",(count($res)>0?$res[0]->cuentasxpagar:0),"","","cuentasxpagar"));$sumaactivo.="-B".$i;$i++;
        array_push($datainversion,Array("- Impuestos por pagar",(count($res)>0?$res[0]->impuestosxpagar:0),"","","impuestosxpagar"));$sumaactivo.="-B".$i;$i++;
        array_push($datainversion,Array("= Capital de trabajo neto","=".$sumaactivo,"=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)",(count($res)>0?$res[0]->totalinversion:0),"capitaltrabajoneto"));$i++;
        array_push($datainversion,Array("","","",""));$i++;
        array_push($datainversion,Array("ACTIVOS NO CIRCULANTES","","",""));$i++;
                //9
        array_push($datainversion,Array("Equipo de oficina",(count($res)>0?$res[0]->equipooficina:0),"=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)",(count($res)>0?$res[0]->totalinversion:0),"equipooficina"));$i++;
        array_push($datainversion,Array("Planta y maquinaria pesada (incluye inmuebles)",(count($res)>0?$res[0]->plantamaquinaria:0),"=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)",(count($res)>0?$res[0]->totalinversion:0),"plantamaquinaria"));$i++;
        array_push($datainversion,Array("Maquinaria y equipo ligero (moldes y troqueles, etc.)",(count($res)>0?$res[0]->maquinariaequipo:0),"=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)",(count($res)>0?$res[0]->totalinversion:0),"maquinariaequipo"));$i++;
        array_push($datainversion,Array("Equipo de transporte",(count($res)>0?$res[0]->equipotransporte:0),"=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)",(count($res)>0?$res[0]->totalinversion:0),"equipotransporte"));$i++;
        array_push($datainversion,Array("Intangibles",(count($res)>0?$res[0]->intangibles:0),"=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)",(count($res)>0?$res[0]->totalinversion:0),"intangibles"));$i++;
        array_push($datainversion,Array("","","",""));$i++;
        array_push($datainversion,Array("OTROS ACTIVOS","","",""));$i++;
                //16
        array_push($datainversion,Array("Gastos de Constitución",(count($res)>0?$res[0]->gastosconstitucion:0),"=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)",(count($res)>0?$res[0]->totalinversion:0),"gastosconstitucion"));$i++;
        array_push($datainversion,Array("Gastos de Asesoría",(count($res)>0?$res[0]->gastosasesoria:0),"=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)",(count($res)>0?$res[0]->totalinversion:0),"gastosasesoria"));$i++;
        array_push($datainversion,Array("Gastos de puesta a punto inmuebles",(count($res)>0?$res[0]->gastospuesta:0),"=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)",(count($res)>0?$res[0]->totalinversion:0),"gastospuesta"));$i++;
        array_push($datainversion,Array("Reclutamiento",(count($res)>0?$res[0]->reclutamiento:0),"=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)",(count($res)>0?$res[0]->totalinversion:0),"reclutamiento"));$i++;
        array_push($datainversion,Array("Seguros pagados por anticipado",(count($res)>0?$res[0]->segurospagados:0),"=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)",(count($res)>0?$res[0]->totalinversion:0),"segurospagados"));$i++;
        array_push($datainversion,Array("Promoción",(count($res)>0?$res[0]->promocion:0),"=IF(OR(B".$i."<=0,D".$i."<=0),0,B21/D21*100)",(count($res)>0?$res[0]->totalinversion:0),"promocion"));$i++;
        array_push($datainversion,Array("Gastos de instalación",(count($res)>0?$res[0]->gastosinstalacion:0),"=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)",(count($res)>0?$res[0]->totalinversion:0),"gastosinstalacion"));$i++;
        array_push($datainversion,Array("Papelería y consumibles",(count($res)>0?$res[0]->papeleria:0),"=IF(OR(B".$i."<=0,D".$i."<=0),0,B".$i."/D".$i."*100)",(count($res)>0?$res[0]->totalinversion:0),"papeleria"));
                
        
		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'        => 'success',
			'datainversion'   => $datainversion,
            'totalinversion'    => (count($res)>0?$res[0]->totalinversion:0)
		]);
	}
    
    /** ==============================================================
	 * FunciÃ³n para duardar los datos.
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
                    $obj[$d[$i][4]]= preg_replace('/[^0-9.]+/', '', $d[$i][1]);//Son solo numeros
                }    
            }
            
            $obj["totalactivosnocirculantes"]=$obj["equipooficina"]+$obj["plantamaquinaria"]+$obj["maquinariaequipo"]+
                        $obj["equipotransporte"]+$obj["intangibles"];
            $obj["totalotrosactivos"]=$obj["gastosconstitucion"]+$obj["gastosasesoria"]+$obj["gastospuesta"]+$obj["reclutamiento"]+
                        $obj["segurospagados"]+$obj["promocion"]+$obj["gastosinstalacion"]+$obj["papeleria"];
            $obj["totalinversion"]=preg_replace('/[^0-9.]+/', '', $request["totalinversion"]);
    		$obj -> save();
            
		}
		catch (Exception $e) { return $e->getMessage();	}

		

		/* Regreso la respuesta exitosa con el total para actualizar el nÃºmero en la vista  */
		return response() -> json([
			'status'  => 'success',
			'msg'     => 'Información guardada con éxito.',
		]);
	}
}