<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ObtenAvanceRequest;
use App\Producto;
use Auth;
use Simulador;
use Session;

class AvanceEtapasController extends Controller
{
    /**
     * Obtiene y regresa las etapas terminadas del usuario
     *
     * @param ObtenAvanceRequest $request
     * @return Response
     */
    function obtenAvance (ObtenAvanceRequest $request)
    {
        $idUser  = Auth::user()->id;
        $idProd  = $request->idProducto;
        $isOwner = Simulador::isOwner($idProd, $idUser);
        if ($isOwner == true)
        {
            $avance = Simulador::getAvance($idUser, $idProd);
            $avance == null ? $avance = 0: null;
            $etapas = Simulador::getEtapasTerminadas($avance);
        }
        Session::put('prodAvance', $idProd);
        return response()->json($etapas,200);
    }

    function mostrarEtapa(Request $request)
    {
        $vista    = Simulador::getEtapaReport($request->etapa);
        $producto = Producto::where('id', $vista[1]->id_producto)->with('catum')->first();
        switch ($vista[0]){
            case 'costeo':
                return response()->json([
                    "costeo"       => $vista[1],
                    "producto"     => $producto,
                    "ingredientes" => json_decode($vista[1]->data),
                    "precioVenta"  => json_decode($vista[1]->dataPrecioVenta)
                    ],200);
            break;
            case 'inventario':
                return response()->json([
                    "inventario"    => $vista[1],
                    "producto"      => $producto,
                    "costoUnitario" => $vista[2]
                ],200);
            break;
            case 'mercadotecnia':
                return response()->json([
                    "mercadotecnia" => $vista[1],
                    "producto"      => $producto,
                ],200);
            break;
            default:
                return response()->json(["message" =>$vista],401);
            break;
        }
    }
}
