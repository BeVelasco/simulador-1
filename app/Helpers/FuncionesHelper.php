<?php

use App\Etapa, App\Producto, App\Catum, App\Costeo, App\Pronostico, App\User;

/* Obtiene el avance del usuario (Etapa en la que se encuentra) */
function obtenAvance($id_user, $id_producto){
	$avance = Etapa::where('id_user', $id_user)
		-> where('id_producto', $id_producto)
		-> where('realizado', 1) 
		-> orderBy('updated_at', 'DESC')
		-> pluck('seccion')
        -> first();
	return $avance;
}

/* Función que regresa una columna específica de un producto mediante su id,
 * si no se especificó ninguna, se regresa todo el producto completo      */
function producto($id_producto, $columna){
	if ($columna == null){
		$idesc = Producto::where('id', $id_producto)->get();
		return $idesc;
	}
    $idesc = Producto::where('id', $id_producto)->pluck($columna);
    return $idesc[0];
}

/* Función que regresa una columna específica de una unidad de medida mediante
 * su id, si no se especificó ninguna, se regresa toda la UM */
function catum($id, $columna){
	if ($columna == null){
		 $catum = Catum::where('id', $id)->get();
	}
    $catum = Catum::where('id', $id)->pluck($columna);
    return $catum[0];
}

/* Función que obtiene el precio de venta de un producto mediante su Id */
function obtenPrecioVenta($idProducto){
    $precioVenta = json_decode(Costeo::whereId_producto($idProducto)->pluck('dataPrecioVenta')->first());
    $precioVenta = str_replace( ',', '', $precioVenta->precioVenta);
	return $precioVenta;
}

/* Funcion que regresa el pronostico del producto de un usuario */
function obtenPronostico($idUser, $idProducto){
	$pronostico = Pronostico::where(['id_user' => $idUser, 'id_producto' => $idProducto])->first();
	return $pronostico;
}

/* Función que elimina las variables de la sesión */
function eliminaVariablesSesion(){
    //if (!is_null(Session::get('prodSeleccionado'))) Session::forget('prodSeleccionado');
    if (!is_null(Session::get('datosCalculados'))) Session::forget('datosCalculados');
    if (!is_null(Session::get('PBBDData'))) Session::forget('PBBDData');
    if (!is_null(Session::get('PBBD'))) Session::forget('PBBD');
    if (!is_null(Session::get('precioVenta'))) Session::forget('precioVenta');
    if (!is_null(Session::get('sumCI'))) Session::forget('sumCI');
    if (!is_null(Session::get('costoUnitario'))) Session::forget('costoUnitario');
    if (!is_null(Session::get('mesInicio'))) Session::forget('mesInici');
    // if (!is_null(Session::get('ventasMensuales'))) Session::forget('ventasMensuales');
    if (!is_null(Session::get('pronostico'))) Session::forget('pronostico');
     //if (!is_null(Session::get('segmentacion'))) Session::forget('segmentacion');
    // if (!is_null(Session::get('NivelSocioEcon'))) Session::forget('NivelSocioEcon');
     //if (!is_null(Session::get('estimacionDemanda'))) Session::forget('estimacionDemanda');
    // if (!is_null(Session::get('proyeccionVentas'))) Session::forget('proyeccionVentas');
    if (!is_null(Session::get('tasaCreVen'))) Session::forget('tasaCreVen');
    return true;
}

/* Función que obtiene el total de productos del ide del usuario enviado */
    function obtenTotalProductos($idUser){
        try{
            $totalProductos = User::find($idUser) -> productos -> count();
            return $totalProductos;
        } catch (Exception $e) { return response() -> json(['message' => $e -> getMessage()], 401); }
    }