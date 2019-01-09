<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Mensaje;
use Auth, View, Session, Lang, Route;

class MensajeroController extends Controller
{
    /* Cabeceras de las columnas */
	protected $colHeaders =[
				'Remitente',
				'Asunto'
			 ];
    
    /** 
	 * ==================================================================== 
	 * Función para mostrar el inicio del simulador, el usuario debe estar
	 * logeado y haber seleccionado un producto para iniciar el simulador
	 * 
	 * @author Emmanuel Hernández Díaz
	 * ====================================================================
	*/
	public function inicio(Request $request)
	{
		/* El usuario debe estar loggeado */
		if ( Auth::check() )
		{
			
		} else {
			return view('auth.login');
		}
	}
    
    /** 
	 * ==============================================================
	 * Regreesar los mensajes de acuerdo al tipo
	 * 
	 * @author Emmanuel Hernández Díaz
	 * ==============================================================
	*/
	public function get_datos(Request $request)
	{
		/* Consultar los mensajes segun usuario y tipo
		 */
   
        /* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
		/* Obtiene los productos registrados por el usuario */
		$tipo = $request->tipo;
        
        /* Obtener los datos de la BD */
        $sql='SELECT asunto,cuerpo 
                            FROM mensajes 
                            WHERE ' . ($tipo!="E" ? 'id_usuario_destino' : 'id_usuario_remite') . ' =:id_usuario
                                AND tipo = :tipo';

        $res = DB::select($sql, ['id_usuario'=>$idUser,'tipo'=>($tipo=="E"?"I":$tipo)]);
        

		/* Regreso la respuesta con los datos para el jExcel */
		return response() -> json([
			'status'               => 'success',
			'data'                 => $res,
			'headers'           => $this->colHeaders,
		]);
	}
    
    /**
	 * [Agrega un nuevo mensaje a la BD]
	 * @param Request $request [Datos enviados por Ajax]
	 */
	public function addMensaje(Request $request)
	{
        $input = $request->except(['_token']);
		
		/* Obtiene el id del usuario */
		$idUser = Auth::user() -> id;

		/* Se agregan los valores enviados por el usuario y se guarda en la BD */
		$mensaje   = new Mensaje();
        foreach ($input as $key => $value)
            $mensaje[$key]=$input[$key];
		$mensaje -> save();

		/* Regreso la respuesta exitosa con el total para actualizar el número en la vista  */
		return response() -> json([
			'status'  => 'success',
			'msg'     => 'Mensaje enviado con exito.',
		]);
	}
}
