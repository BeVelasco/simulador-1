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

use App\Producto;
use App\Catum;
use App\USer;
use Auth;

class SimuladorController extends Controller
{
	public function inicio(Request $request)
	{
		return view('simulador.simulador.inicio');
	}
}
