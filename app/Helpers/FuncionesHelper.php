<?php

use App\Etapa;
use App\Producto;
use App\Catum;
use App\Costeo;
use App\Pronostico;
use App\User;

/* Función que regresa una columna específica de un producto mediante su id,
 * si no se especificó ninguna, se regresa todo el producto completo      */
function producto($id_producto, $columna)
{
    if ($columna == null)
    {
		$idesc = Producto::where('id', $id_producto)->get();
		return $idesc;
	}
    $idesc = Producto::where('id', $id_producto)->pluck($columna);
    return $idesc[0];
}

/* Función que regresa una columna específica de una unidad de medida mediante
 * su id, si no se especificó ninguna, se regresa toda la UM */
function catum($id, $columna)
{
    if ($columna == null)
    {
		 $catum = Catum::where('id', $id)->get();
	}
    $catum = Catum::where('id', $id)->pluck($columna);
    return $catum[0];
}

/* Función que obtiene el precio de venta de un producto mediante su Id */
function obtenPrecioVenta($idProducto)
{
    $precioVenta = json_decode(Costeo::whereId_producto($idProducto)->pluck('dataPrecioVenta')->first());
    $precioVenta = str_replace( ',', '', $precioVenta->precioVenta);
	return $precioVenta;
}

/* Función que obtiene el total de productos del ide del usuario enviado */
    function obtenTotalProductos($idUser)
    {
        try
        {
            $totalProductos = User::find($idUser) -> productos -> count();
            return $totalProductos;
        } 
        catch (Exception $e)
        { 
            return response() -> json(['message' => $e -> getMessage()], 401); 
        }
    }