<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MercadotecniaController extends Controller
{
    public function index(Request $request){
        return view('simulador.mercadotecnia.index');
    }
}
