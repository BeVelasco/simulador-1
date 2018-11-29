<?php
/*
 * Controlador para la guía (tutorial) que informará al usuario
 * el siguiente paso a seguir en el simulador.
 *
 * @author Emmanuel Hernandez Diaz
 * @propietario Integra Ideas Consultores - 2018
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Guia;

class GuiaController extends Controller
{
	/* Funcion para mostrar el mensaje del paso que se solicita mendiante request */
	public function mostrarMensaje(Request $request)
	{
		/* Reglas de validacion */
		$rules = [
			'paso' => ['required','numeric']
		];
		/* Se validan los datos con las reglas y mensajes especificados */
		$validate = \Validator::make($request->all(), $rules);
		if ($validate -> fails())
		{
			return response()->json([
				'status' => 'error',
				'msg'    => $validate->errors()->first()]);
		} else {
			/* Se verifica que el paso existe en la BD */
			$paso = $request -> paso;
			$res = Guia::find($paso);
			if (!$res)
			{
				/* Regresa un error indicando que no se encontró el paso */
				return response() -> json([
					'status' => 'error',
					'msg'    => 'No se encontró la unidad de medida, actualice la página.',
				]);
			} else {
				/* Regresa el mensaje del paso recibido */
				return response()->json([
					'status'  => 'success',
					'msg' => $res -> mensaje,
				]);
			}
			
		}
   }
}
