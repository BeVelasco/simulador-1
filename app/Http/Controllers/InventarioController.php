<?php

namespace App\Http\Controllers;

use Session, Reloader, URL, App\Pronostico, Auth;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(Request $request){
        $pronostico    = Reloader::getPronostico(Auth::user() -> id, Session::get('prodSeleccionado'));
        $costoUnitario = Reloader::getCostoUnitario(Session::get('prodSeleccionado'));
        Session::put('pronostico', $pronostico);
        Session::put('costoUnitario', $costoUnitario);
        return view('simulador.inventario.index');
    }
    public function guardar(Request $request){
        $respuesta = guardaInventario($request);
        if ($respuesta == "true"){ 
            $guardaEtapa = terminarEtapa(Auth::user()->id,Session::get('prodSeleccionado'), 3);
            if ($guardaEtapa == "true"){return response() -> json(["message" => "Guardado", "ruta" => URL::route('mercadotecnia'),],200);
            } else { return response() -> json(["message" => $guardarEtapa], 401);}
        } else { return response () -> json(["message" => $respuesta,],401); }
    }
}
