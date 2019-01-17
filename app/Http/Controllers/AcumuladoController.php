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


class AcumuladoController extends Controller
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
			     return view('/simulador/acumulado/acumulado');
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
	public function get_acumulado(Request $request)
	{
		/* Inserto la variable en la sesion, puede ser true o false*/
		$id_producto=Session::get('prodSeleccionado')->id;
        
        /* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
        
        
        $insumos=get_insumos($id_producto,$idUser);
        $formulacion=get_formulacion($id_producto,$idUser);
        $ventas=get_ventas($id_producto,$idUser);
        
		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'         => 'success',
			'insumos'        => $insumos,
            'formulacion'    => $formulacion,
            'ventas'         => $ventas,
		]);
	}
    
    /** 
	 * ==============================================================
	 * Insumos de productos
	 * ==============================================================
	*/
	public function get_insumos($id_producto,$idUser)
	{
        
        /* Obtener los datos de la BD */
        $sql='SELECT pin.`insumo`,pin.`um`,pin.`piezasxunidad`,total AS `unitario`
            FROM `productos` AS p
            	LEFT JOIN `productosinsumos` AS pin ON p.`id`=pin.`id_productos`
            WHERE p.`id_user_r`=:id_usuario AND p.`id`=:id_producto';

        $datos = DB::select($sql, ['id_usuario'=>$idUser,'id_producto'=>$id_producto]);
        
        /* Totales */
        $sql='SELECT sum(total) AS `total`
            FROM `productos` AS p
            	LEFT JOIN `productosinsumos` AS pin ON p.`id`=pin.`id_productos`
            WHERE p.`id_user_r`=:id_usuario AND p.`id`=:id_producto';

        $total = DB::select($sql, ['id_usuario'=>$idUser,'id_producto'=>$id_producto]);
        
        return Array("datos"=>$datos,"total"=>$total);
	}
    
    /** 
	 * ==============================================================
	 * Formulación de productos
	 * ==============================================================
	*/
	public function get_formulacion($id_producto,$idUser)
	{
        
        /* Obtener los datos de la BD */
        $sql='SELECT t.proceso,t.promedio
            FROM productos AS p
            	LEFT JOIN `tktformulas` AS t ON p.`id`=t.id_productos
            WHERE p.`id_user_r`=:id_usuario AND p.`id`=:id_producto';

        $datos = DB::select($sql, ['id_usuario'=>$idUser,'id_producto'=>$id_producto]);
        
        /* Totales */
        $sql='SELECT sum(t.promedio) AS `total`
            FROM productos AS p
            	LEFT JOIN `tktformulas` AS t ON p.`id`=t.id_productos
            WHERE p.`id_user_r`=:id_usuario AND p.`id`=:id_producto';

        $total = DB::select($sql, ['id_usuario'=>$idUser,'id_producto'=>$id_producto]);
        
        return Array("datos"=>$datos,"total"=>$total);
	}
    
    /** 
	 * ==============================================================
	 * Ventas mensuales
	 * ==============================================================
	*/
	public function get_ventasmensuales($id_producto,$idUser)
	{
        
        /* Obtener los datos de la BD */
        $sql='SELECT t.proceso,t.promedio
            FROM productos AS p
            	LEFT JOIN `tktformulas` AS t ON p.`id`=t.id_productos
            WHERE p.`id_user_r`=:id_usuario AND p.`id`=:id_producto';

        $datos = DB::select($sql, ['id_usuario'=>$idUser,'id_producto'=>$id_producto]);
        
        /* Totales */
        $sql='SELECT sum(t.promedio) AS `total`
            FROM productos AS p
            	LEFT JOIN `tktformulas` AS t ON p.`id`=t.id_productos
            WHERE p.`id_user_r`=:id_usuario AND p.`id`=:id_producto';

        $total = DB::select($sql, ['id_usuario'=>$idUser,'id_producto'=>$id_producto]);
        
        return Array("datos"=>$datos,"total"=>$total);
	}
}