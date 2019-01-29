<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request, Reloader, Auth, Session;
use App\Mercadotecnia;

class MercadotecniaController extends Controller
{
    public function index(Request $request){
        return view('simulador.mercadotecnia.index');
    }

    public function guardarMercadotecnia(Request $request){
        $mercadotecnia = Mercadotecnia::where(['id_producto'=>Session::get('prodSeleccionado'), 'id_user'=>Auth::user()->id])->first();
        if ($mercadotecnia == null){
            $mercadotecnia              = New Mercadotecnia;
            $mercadotecnia->id_user     = Auth::user()->id;
            $mercadotecnia->id_producto = Session::get('prodSeleccionado');
        }
        $mercadotecnia->tipoMercadotecnia = $request->tipoMercadotecnia;
        $mercadotecnia->precio            = $request->precio;
        $mercadotecnia->promocion         = $request->promocion;
        if ($request->clientesInternos == null){ $mercadotecnia->clientesInternos = 0; } else { $mercadotecnia->clientesInternos = $request->clientesInternos; }
        if ($request->relacionesPublicas == null){ $mercadotecnia->relacionesPublicas = 0; } else { $mercadotecnia->relacionesPublicas = $request->relacionesPublicas; }
        if ($request->canalesDistribucion == null){ $mercadotecnia->canalesDistribucion = 0; } else { $mercadotecnia->canalesDistribucion = $request->canalesDistribucion; }
        if ($request->producto == null){ $mercadotecnia->producto = 0; } else { $mercadotecnia->producto = $request->producto; }
        $mercadotecnia->total = array_sum((Array)$request->except('tipoMercadotecnia'));

        $mercadotecnia->save();

        $respuesta = terminarEtapa(Auth::user()->id, Session::get('prodSeleccionado'), 4);
        if ($respuesta == 'true'){
            return response()->json(['message'=>'Datos de mercadotecnia guardados con éxito'], 200);
        } else {
            return response()->json(['message'=>$respuesta],401);
        }
        
    }
}
