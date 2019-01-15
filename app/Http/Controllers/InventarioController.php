<?php

namespace App\Http\Controllers;

use Session, URL, App\Pronostico, Auth;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(Request $request){
        $pronostico = Pronostico::where('id_user', Auth::user() -> id)
                                ->where('id_producto', Session::get('prodSeleccionado.id'))
                                ->first();
        $costoUnitario = obtenCostoUnitario(Session::get('prodSeleccionado.id'));
        Session::put('pronostico', $pronostico);
        Session::put('costoUnitario', $costoUnitario);
        return view('simulador.inventario.index');
    }
    /* Función que guarda la valuacion de inventario deseado en la BD */
    public function guardar(Request $request){
        $respuesta = guardaInventario($request);
        if ($respuesta == "true"){
            /* Si todo sale bien se manda un mensaje de guardado y la ruta de la nueva vista a renderizar */
            return response() -> json([
                "message" => "Guardado",
                "ruta"    => URL::route('mercadotecnia'),
            ],200);
        } else return response () -> json(["message" => $respuesta,],401);
    }
}
