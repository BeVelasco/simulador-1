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

use App\Producto, App\Catum, App\User, App\Etapa, App\Situacioninicial;
use Auth, View, Session, Lang, Route;


class SituacioninicialController extends Controller
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
	public function editarInicioSituacion(Request $request)
	{
		/* El usuario debe estar loggeado */
		if ( Auth::check() )
		{
			
			/* El usuario debe tener un producto seleccionado */
			/*if ( Session::get('prodSeleccionado') == null )
			{
				return redirect('/productomenu');
			} else {*/
			     return view('/simulador/inicial/situacioninicial');
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
	public function get_situacion(Request $request)
	{
        
        /* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
        /* inventarios */
        $sqlinv='SELECT COALESCE(SUM(i.`valInvFinDes`),0) AS valInvFinDes
                FROM `inventarios` AS i
                WHERE i.`id_user`=:id_usuario';
        $resinv = DB::select($sqlinv, ['id_usuario'=>$idUser]);
        
        /* inversiÃ³n inicial */
        $sqlii='SELECT `efectivo`,`cuentasxcobrar`,`cuentasxpagar`,`impuestosxpagar`,`capitaltrabajoneto`,`equipooficina`,`plantamaquinaria`
                	,`maquinariaequipo`,`equipotransporte`,`intangibles`,`gastosconstitucion`,`gastosasesoria`,`gastospuesta`,`reclutamiento`
                	,`segurospagados`,`promocion`,`gastosinstalacion`,`papeleria`,`totalinversion`,totalotrosactivos,totalactivosnocirculantes
                FROM `inversioninicials`
            WHERE `id_user`=:id_usuario';
        $resii = DB::select($sqlii, ['id_usuario'=>$idUser]);

        /* situaciÃ³n inicial */
        $sqlsi='SELECT `prestamoaccionistas`,`prestamolargoplazo`,`inversionaccionistas`,utilidadreservas,`porcgastos2`,`porcgastos3`
                    ,`oficinas`,`servpublicos`,`telefonos`,`seguros`,`papeleria`,`rentaequipo`,`costoweb`,`costoconta`
                    ,`honorariolegal`,`viajesysubsistencia`,`gastosautos`,`gastosgenerales`,`cargosbancarios`,`otrosservicios`
                    ,`gastosinvestigacion`,`gastosdiversos`,`tasalider`,`primariesgo`,`riesgopais`
                FROM `situacioninicials`
            WHERE `id_user`=:id_usuario';

        $res = DB::select($sqlsi, ['id_usuario'=>$idUser]);
        $datasituacion=Array();
        
        $cuentaresinv=count($resinv);
        $cuentaresii=count($resii);
        $cuentares=count($res);
        
        array_push($datasituacion,Array("ACTIVO CIRCULANTE","","PASIVO CIRCULANTE","","ne-0,1,2,3"));
        array_push($datasituacion,Array("Efectivo",($cuentaresii>0?$resii[0]->efectivo:0),"Cuentas por pagar",($cuentaresii>0?$resii[0]->cuentasxpagar:0),"ne-0,1,2,3"));
        array_push($datasituacion,Array("Inventarios",($cuentaresinv>0?$resinv[0]->valInvFinDes:0),"Impuestos por pagar",($cuentaresii>0?$resii[0]->impuestosxpagar:0),"ne-0,1,2,3"));
        array_push($datasituacion,Array("Cuentas por cobrar",($cuentaresii>0?$resii[0]->cuentasxcobrar:0),"","","ne-0,1,2,3"));
        array_push($datasituacion,Array("","","","","ne-0,1,2,3"));
        array_push($datasituacion,Array("ACTIVO NO CIRCULANTE","","RECURSOS PERMANENTES","","ne-0,1,2,3"));
        array_push($datasituacion,Array("Equipo de oficina",($cuentaresii>0?$resii[0]->equipooficina:0),"","","ne-0,1,2,3"));
        array_push($datasituacion,Array("","","PASIVO FIJO","","ne-0,1,2,3"));
        array_push($datasituacion,Array("Planta y maquinaria",($cuentaresii>0?($resii[0]->plantamaquinaria+$resii[0]->maquinariaequipo):0),"Préstamo de accionistas y directivos",($cuentares>0?$res[0]->prestamoaccionistas:0),"ne-0,1,2"));
        array_push($datasituacion,Array("","","Préstamos de largo plazo",($cuentares>0?$res[0]->prestamolargoplazo:0),"ne-0,1,2"));
        array_push($datasituacion,Array("Intangibles",($cuentaresii>0?$resii[0]->intangibles:0),"","","ne-0,1,2,3"));
        array_push($datasituacion,Array("","","CAPITAL CONTABLE","","ne-0,1,2,3"));
        array_push($datasituacion,Array("Otros activos (incluye equipo de transporte)",($cuentaresii>0?$resii[0]->totalotrosactivos:0),"Inversión Accionistas",($cuentares>0?$res[0]->inversionaccionistas:0),"ne-0,1,2"));
        array_push($datasituacion,Array("","","Utilidades y reservas acumuladas","=B15-D13-D10-D9-D3-D2","ne-0,1,2,3"));
        array_push($datasituacion,Array("Sumas iguales","=B2+B3+B4+B7+B9+B11+B13","Sumas iguales","=D2+D3+D9+D10+D13+D14","ne-0,1,2,3"));

        /* ventas mensuales */
        $sqlventas='
            SELECT mes,COALESCE(SUM(total),0) AS total
            FROM `ventas_mensuales`
            WHERE `id_user`=:id_usuario
            GROUP BY mes
            ORDER BY STR_TO_DATE(CONCAT(`meses_to_eng`(`mes`),"01 2000"), "%M %d %Y")';

        $res = DB::select($sqlventas, ['id_usuario'=>$idUser]);
        $dataventas=Array();
        for($i=0;$i<count($res)/2;$i++){
            array_push($dataventas,Array($res[$i]->mes,$res[$i]->total,$res[$i+6]->mes,$res[$i]->total));   
        }
        
        /**********************/
        /* Gastos operativos */
        $sqlgastos='
            SELECT `porcgastos2`,`porcgastos3`,`oficinas`,`servpublicos`,`telefonos`,`seguros`,`papeleria`,`rentaequipo`
            	,`costoweb`,`costoconta`,`honorariolegal`,`viajesysubsistencia`,`gastosautos`
            	,`gastosgenerales`,`cargosbancarios`,`otrosservicios`,`gastosinvestigacion`,`gastosdiversos`
                ,totalgastos,`tasalider`,`primariesgo`,`riesgopais`
            FROM `situacioninicials`
            WHERE `id_user`=:id_usuario';

        $resgas = DB::select($sqlgastos, ['id_usuario'=>$idUser]);
        $datagastos=Array();$datagastosinc=Array();
        $cuentagas=count($resgas);
        $totalgastos=0;
        
        /* sueldos y salarios */
        $sqlsalarios='
            SELECT sumanomina
            FROM `nominas`
            WHERE `id_user`=:id_usuario';

        $ressal = DB::select($sqlsalarios, ['id_usuario'=>$idUser]);
        $datasal=Array();
        $cuentasal=count($ressal);
        $totalgastos+=($cuentasal>0?$ressal[0]->sumanomina:0);
        
        /* mercadotecnia */
        $sqlmerca='
            SELECT COALESCE(SUM(total),0) as total
            FROM `mercadotecnias`
            WHERE `id_user`=:id_usuario';

        $resmerca = DB::select($sqlmerca, ['id_usuario'=>$idUser]);
        $datamerca=Array();
        $cuentamerca=count($resmerca);
        $totalgastos+=($cuentamerca>0?$resmerca[0]->total:0);
        
        array_push($datagastos,Array("GASTOS ANUALES","Año 1","GASTOS ANUALES","Año 1","ne-0,1,2,3"));
        array_push($datagastos,Array("Oficinas y rentas",($cuentagas>0?$resgas[0]->oficinas:0),"Honorarios legales",($cuentagas>0?$resgas[0]->honorariolegal:0),"ne-0,2"));
        array_push($datagastos,Array("Salarios y obligaciones",($cuentasal>0?$ressal[0]->sumanomina:0),"Viajes y subsistencia",($cuentagas>0?$resgas[0]->viajesysubsistencia:0),"ne-0,1,2"));
        array_push($datagastos,Array("Servs. Públicos (agua, luz, etc)",($cuentagas>0?$resgas[0]->servpublicos:0),"Gastos de autos",($cuentagas>0?$resgas[0]->gastosautos:0),"ne-0,2"));
        array_push($datagastos,Array("Teléfonos",($cuentagas>0?$resgas[0]->telefonos:0),"Gastos generales",($cuentagas>0?$resgas[0]->gastosgenerales:0),"ne-0,2"));
        array_push($datagastos,Array("Seguros",($cuentagas>0?($resgas[0]->seguros):0),"Cargos bancarios",($cuentagas>0?$resgas[0]->cargosbancarios:0),"ne-0,2"));
        array_push($datagastos,Array("Papelería y envíos",($cuentagas>0?($resgas[0]->papeleria):0),"Otros servicios",($cuentagas>0?$resgas[0]->otrosservicios:0),"ne-0,2"));
        array_push($datagastos,Array("Renta de equipo de oficina",($cuentagas>0?$resgas[0]->rentaequipo:0),"Gastos de mercadotecnia",($cuentamerca>0?$resmerca[0]->total:0),"ne-0,2,3"));
        array_push($datagastos,Array("Costos de sitio web",($cuentagas>0?$resgas[0]->costoweb:0),"Gastos de investigación",($cuentagas>0?$resgas[0]->gastosinvestigacion:0),"ne-0,2"));
        array_push($datagastos,Array("Costos de contabilidad",($cuentagas>0?($resgas[0]->costoconta):0),"Gastos diversos",($cuentagas>0?($resgas[0]->gastosdiversos):0),"ne-0,2"));
        
        array_push($datagastosinc,Array("porcgastos2"=>($cuentagas>0?($resgas[0]->porcgastos2):0)));
        array_push($datagastosinc,Array("porcgastos3"=>($cuentagas>0?($resgas[0]->porcgastos3):0)));
        
        $datatasadescuento=Array();
        array_push($datatasadescuento,Array("tasalider"=>($cuentagas>0?$resgas[0]->tasalider:0)));
        array_push($datatasadescuento,Array("primariesgo"=>($cuentagas>0?$resgas[0]->primariesgo:0)));
        array_push($datatasadescuento,Array("riesgopais"=>($cuentagas>0?$resgas[0]->riesgopais:0)));
        
        /* Costos */
        $sqlcostos='
            SELECT (100-PBBD) as `costoprimo`
            FROM `costeoproductos`
            WHERE `id_user`=:id_usuario';

        $rescostos = DB::select($sqlcostos, ['id_usuario'=>$idUser]);
        $datacostos=Array();
        $cuentacostos=count($rescostos);
        
		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'         => 'success',
            'totalgastos'    => $totalgastos,//$cuentagas>0?$resgas[0]->totalsituacion:0),
			'datasituacion'  => $datasituacion,
            'dataventas'     => $dataventas,
            'datagastos'     => $datagastos,
            'datagastosinc'  => $datagastosinc,
            'datatasadescuento'  => $datatasadescuento,
            'costoprimo'     => ($cuentacostos>0?$rescostos[0]->costoprimo:0)
		]);
	}
    
    /** ==============================================================
	 * FunciÃ³n para duardar los datos.
	 * ==============================================================
     */
	public function set_situacion(Request $request)
	{
        $input = $request->except(['_token']);
		
		/* Obtiene el id del usuario */
		$idUser = Auth::user() -> id;
        
    
        try{
			$obj = Situacioninicial::where('id_user', $idUser)
				->first();
			if ( $obj == null ){
			     /* Se agregan los valores enviados por el usuario y se guarda en la BD */
        		$obj   = new Situacioninicial();
                
                $obj["id_user"]=$idUser;
            }
            //Leer el json del excel
            $d=$request["datos"];
            for($i=0;$i<count($d);$i++){
                foreach($d[$i] as $key=>$value){
                    //Llenar el arreglo segun el nombre de campo con el valor de las columna 2 del JExcel
                    $obj[$key]= preg_replace('/[^0-9.]+/', '', $value);//Son solo numeros
                }
            }
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