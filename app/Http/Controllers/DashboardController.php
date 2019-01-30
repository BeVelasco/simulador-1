<?php
/**
 * Este archivo forma parte del Simulador de Negocios.
 *
 * (c) Emmanuel HernÃ¡ndez <emmanuelhd@gmail.com>
 *
 *  Enero - 2019
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request, App\Catum, App\Producto, App\User, App\Etapa, App\Pronostico, Auth, Session, Reloader;

class DashboardController extends Controller
{
	public function index(){
		$idUser    = Auth::user() -> id;
		/* Obtiene los productos registrados por el usuario */
        $proyecto  = User::find($idUser) -> proyecto;
		$productos = User::find($idUser) -> productos() -> paginate(10);
		$totProd   = User::find($idUser) -> productos() -> count();
		$um        = Catum::all() -> sortBy('idesc');
		Reloader::deleteSessionVariables();
		return view('home',['unidadMedidas'=>$um,'noProductos'=>$totProd,'productos'=>$productos,'noCatum'=>$um->count(),'proyecto'=>$proyecto]);
	}

	public function addUnidadMedida(Request $request){
		$um    = $request->descripcion;
		$catum = new Catum();
		$catum -> idesc = $um;
		$catum -> save();
		$id = Catum::count();
		return response()->json(['status'=>'success','msg'=>'Unidad '.$um.' guardada con éxito','option'=>$um,'val'=>$id]);
	}

	public function addProducto(Request $request){
		$desc    = $request -> descripcion;
		$um      = strip_tags($request -> unidadMedida);
		$porcion = $request -> porcion;
		$res     = Catum::find($um);
		$idUser  = Auth::user() -> id;
		$prod    = new Producto();
		$prod -> idesc          = $desc;
		$prod -> idcatnum1      = $um;
		$prod -> porcionpersona = $porcion;
		$prod -> id_user_r      = $idUser;
		$prod -> save();
		$porcion = $porcion.' - '.Catum::find($um) -> idesc;
		$idProd  = Producto::all() -> last() -> id;
		$totProd = obtenTotalProductos($idUser);
		$boton   = obtenVista('simulador.componentes.boton');
		$boton   = str_replace("%id%", $idProd, $boton);
		return response() -> json(['status'=>'success','message'=>'Producto '.$desc.' agregado con exito.','totProd'=>$totProd,'desc'=>$desc,'porcion'=>$porcion,'boton'=>$boton],200);
	}

	/**
 * [Editar nombre del proyecto]
 * @param Request $request [Datos enviados por Ajax]
 * Jaime vázquez
 */
	public function addProyecto(Request $request){
		 /* Mensajes personalizados cuando hay errores en la validaciÃ³n */
		$messages = [
			'required' => 'El campo :attribute es obligatorio.'
		];

		/* Reglas de validacion */
		$rules = [
			'descripcion'  => ['required','max:100','regex:/^[0-9\pL\s\-]+$/u'],
		];
		/* Se validan los datos con las reglas y mensajes especificados */
		$data = \Validator::make($request -> all(), $rules, $messages);
		/* Si la validaciÃ³n falla, regreso solamente el primer error. */
		if ($data -> fails()){ return response() -> json(['status' => 'error','msg' => $data -> errors() -> first()], 401); }
		/* Sanitiza los datos y pone el primer caracter en mayuscula */
		$proyecto    = ucfirst(strip_tags($request -> descripcion));

				/* Obtiene el id del usuario */
				$idUser    = Auth::user() -> id;

		/* Se agregan los valores enviados por el usuario y se guarda en la BD */
		try {
						$user               = User::find($idUser);
			$user -> proyecto   = $proyecto;
			$user -> save();
		} catch (Exception $e) { return response() -> json(['message' => $e -> getMessage()], 401);	}
		/* Regreso la respuesta exitosa con el total para actualizar el nÃºmero en la vista  */
		return response() -> json([
			'status'  => 'success',
			'message' => 'Proyecto nombrado con éxito.',
			'desc'    => $proyecto,
		], 200);
	}

	public function iniciarSimulador(Request $request){
		$respuesta = Reloader::setProdSession(Auth::user() -> id, $request -> iP);
		if ($respuesta != "true"){ return response() -> json(['message' => $respuesta] ,401);}
		return response() -> json(['message' => 'Correcto'],200);
	}
}
