<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mercadotecnia;
use Reloader;
use Auth;
use Session;

class MercadotecniaController extends Controller
{
    public function index(Request $request)
    {
        return view('simulador.mercadotecnia.index');
    }

    public function guardarMercadotecnia(Request $request)
    {
        $mercadotecnia = Mercadotecnia::where([
            'id_producto'=>Session::get('prodSeleccionado'), 
            'id_user'=>Auth::user()->id
            ])->first();
        if ($mercadotecnia == null)
        {
            $mercadotecnia              = New Mercadotecnia;
            $mercadotecnia->id_user     = Auth::user()->id;
            $mercadotecnia->id_producto = Session::get('prodSeleccionado');
        }
        $mercadotecnia->tipoMercadotecnia = $request->tipoMercadotecnia;
        $mercadotecnia->precio            = $request->precio;
        $mercadotecnia->promocion         = $request->promocion;

        $request->clientesInternos    == null ? $request->clientesInternos    = 0 : null;
        $request->relacionesPublicas  == null ? $request->relacionesPublicas  = 0 : null;
        $request->canalesDistribucion == null ? $request->canalesDistribucion = 0 : null;
        $request->producto            == null ? $request->producto = 0 : null;
        
        $mercadotecnia->clientesInternos    = $request->clientesInternos;
        $mercadotecnia->relacionesPublicas  = $request->relacionesPublicas;
        $mercadotecnia->canalesDistribucion = $request->canalesDistribucion;
        $mercadotecnia->producto            = $request->producto;
        $mercadotecnia->total               = array_sum((Array)$request->except('tipoMercadotecnia'));
        $mercadotecnia->save();

        $respuesta = terminarEtapa(Auth::user()->id, Session::get('prodSeleccionado'), 4);
        if ($respuesta == 'true'){
            return response()->json(['message'=>'Datos de mercadotecnia guardados con éxito'], 200);
        } else {
            return response()->json(['message'=>$respuesta],401);
        }
        
    }
}
