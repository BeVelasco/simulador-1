<?php namespace App\Http\Controllers;

use Session;
use Simulador;
use URL;
use Auth;
use App\Pronostico;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $pronostico    = Simulador::getPronostico(Auth::user() -> id, Session::get('prodSeleccionado'));
        $costoUnitario = Simulador::getCostoUnitario(Session::get('prodSeleccionado'));
        Session::put('pronostico', $pronostico);
        Session::put('costoUnitario', $costoUnitario);
        return view('simulador.inventario.index');
    }
    public function guardar(Request $request)
    {
        $respuesta = guardaInventario($request);
        if ($respuesta == "true")
        { 
            $guardaEtapa = terminarEtapa(Auth::user()->id,Session::get('prodSeleccionado'), 3);
            if ($guardaEtapa == "true")
            {
                return response() -> json(["message" => "Guardado", "ruta" => URL::route('mercadotecnia'),],200);
            } 
            else 
            { 
                return response() -> json(["message" => $guardarEtapa], 401);
            }
        } 
        else 
        {
            return response () -> json(["message" => $respuesta,],401);
        }
    }
}
