<?php
/**
 * Este archivo forma parte del Simulador de Negocios.
 *
 * (c) Emmanuel HernÃ¡ndez <emmanuelhd@gmail.com>
 *
 *  Prohibida su reproducciÃ³n parcial o total sin 
 *  consentimiento explÃ­cito de Integra Ideas Consultores.
 *
 *  Enero - 2018
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Catum, App\Producto, App\User, App\Etapa, App\Pronostico;

use Auth, Session;

class DashboardController extends Controller
{
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		/* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
		/* Obtiene los productos registrados por el usuario */
        $proyecto  = User::find($idUser) -> proyecto;
		$productos = User::find($idUser) -> productos() -> paginate(10);
		$totProd   = User::find($idUser) -> productos() -> count();
		/* Obtengo las UM ordenadas */
		$um        = Catum::all() -> sortBy('idesc');
		/* Return the view withe some needed variables */
		return view('home',[
            'proyecto'      => $proyecto,
			'unidadMedidas' => $um,
			'noProductos'   => $totProd,
			'productos'     => $productos,
			'noCatum'       => $um -> count(),
		]);
	}
	/* FunciÃ³n que agrega una UM a la BD */
	public function addUnidadMedida(Request $request){
		/* Mensajes personalizados cuando hay errores en la validaciÃ³n */
		$messages = [
			'unique'   => 'La unidad de medida ya existe.',
			'required' => 'Debe ingresar el nombre de la unidad de medida.',
			'regex'    => 'El campo :attribute solo acepta letras.'
		];
		/* Reglas de validacion */
		$rules = ['descripcion' => ['required','max:50','unique:catums,idesc','regex:/^[0-9\pL\s\-]+$/u']];
		/* Se validan los datos con las reglas y mensajes especificados */
		$validate = \Validator::make($request->all(), $rules, $messages);
		/* Si la validaciÃ³n falla, regreso solamente el primer error. */
		if ($validate -> fails()){ return response()->json(['status' => 'error','msg'    => $validate->errors()->first()]);	}
		/* Sanitiza los datos y pone el primer caracter en mayuscula */
		$um    = ucfirst(strip_tags($request->descripcion));
		$catum = new Catum();
		/* Agrega los campos que son necesarios */
		$catum -> idesc =  $um;
		$catum -> save();
		/* Obtengo el total de unidades de medida existentes */
		$id = Catum::count();
		/* Regreso la respuesta exitosa con los datos para agregar al select la nueva opciÃ³n */
		return response()->json([
			'status' => 'success',
			'msg'    => 'Unidad '.$um.' guardada con éxito',
			'option' => $um,
			'val'    => $id
		]);
	}

	/**
	 * [Agrega un nuevo producto a la BD]
	 * @param Request $request [Datos enviados por Ajax]
	 */
	public function addProducto(Request $request){
		/* Mensajes personalizados cuando hay errores en la validaciÃ³n */
		$messages = [
			'numeric'  => 'El valor de :attribute no corresponde a un nÃºmero',
			'unique'   => 'El producto ya existe.',
			'regex'    => 'El valor introducido en :attribute no es correcto.',
			'required' => 'El campo :attribute es obligatorio.'
		];
		/* Reglas de validacion */
		$rules = [
			'descripcion'  => ['required','max:100','unique:productos,idesc','regex:/^[0-9\pL\s\-]+$/u'],
			'unidadMedida' => ['required','numeric'],
			'porcion'      => ['required','numeric','regex:/(?!^0*$)(?!^0*\.0*$)^\d{1,6}(\.\d{1,2})?$/u'],
		];
		/* Se validan los datos con las reglas y mensajes especificados */
		$data = \Validator::make($request -> all(), $rules, $messages);
		/* Si la validaciÃ³n falla, regreso solamente el primer error. */
		if ($data -> fails()){ return response() -> json(['status' => 'error','msg' => $data -> errors() -> first()], 401); }
		/* Sanitiza los datos y pone el primer caracter en mayuscula */
		$desc    = ucfirst(strip_tags($request -> descripcion));
		$um      = strip_tags($request -> unidadMedida);
		$porcion = $request -> porcion;
		/* Se verifica si la categorÃ­a existe en la BD, si no se encuentra
		   se manda un mensaje de error solicitando el refresco de la pÃ¡gina */
		$res = Catum::find($um);
		if (!$res){ return response() -> json(['status' => 'error','message' => 'No se encontrÃ³ la unidad de medida, actualice la pÃ¡gina.',], 401); }
		/* Obtiene el id del usuario */
		$idUser = Auth::user() -> id;
		/* Se agregan los valores enviados por el usuario y se guarda en la BD */
		try {
			$prod                   = new Producto();
			$prod -> idesc          = $desc;
			$prod -> idcatnum1      = $um;
			$prod -> porcionpersona = $porcion;
			$prod -> id_user_r      = $idUser;
			$prod -> save();
		} catch (Exception $e) { return response() -> json(['message' => $e -> getMessage()], 401);	}
		$porcion = $porcion.' - '.Catum::find($um) -> idesc;
		/* Obtengo el id del producto guardado */
		$idProd  = Producto::all() -> last() -> id;
		/* Obtengo el total de productos que tiene registrado el usuario */
		$totProd = obtenTotalProductos($idUser);
		/* Creo el botÃ³n que se agregarÃ¡ al HTML */
		$boton   = obtenVista('simulador.componentes.boton');
		/* Inserta el id del producto creado en el nuevo botÃ³n */
		$boton = str_replace("%id%", $idProd, $boton);
		/* Regreso la respuesta exitosa con el total para actualizar el nÃºmero en la vista  */
		return response() -> json([
			'status'  => 'success',
			'message' => 'Producto '.$desc.' agregado con éxito.',
			'totProd' => $totProd,
			'desc'    => $desc,
			'porcion' => $porcion,
			'boton'   => $boton
		], 200);
	}
    
    /**
	 * [Agrega un nuevo producto a la BD]
	 * @param Request $request [Datos enviados por Ajax]
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
    
	/**
	 * FunciÃ³n para comenzar el simulador dependiendo de la etapa en la que
	 * el usario se quedÃ³ la Ãºltima vez que utilizÃ³ el simulador
	 */
	public function iniciarSimulador(Request $request){
		/* Mensajes personalizados cuando hay errores en la validaciÃ³n */
		$messages = [
			'exists'   => 'El :attribute no existe.',
			'required' => 'El campo :attribute es obligatorio.',
		];
		/* Reglas de validacion */
		$rules = ['iP' => ['required','exists:productos,id'],];
		/* Se validan los datos con las reglas y mensajes especificados */
		$validate = \Validator::make($request -> all(), $rules, $messages);
		/* Si la validaciÃ³n falla, regreso solamente el primer error. */
		if ($validate -> fails()){ return response() -> json(['status' => 'error','message' => $validate -> errors() -> first()], 401); }
		/* Verifica que el usuario estÃ© logeado y coincida con el id que enviÃ³*/
		$idProd   = $request -> iP;
		$producto = Producto::find($idProd);
		if (  $producto -> id_user_r == Auth::user() -> id ){
			/* Agrego a la sesiÃ³n el id del producto seleccionado */
			Session::put('prodSeleccionado', $producto->id);
			return response() -> json([
				'status'  => 'success',
				'message' => 'Correcto'
			],200);
		} else { return response() -> json(['status' => 'error','message' => 'Datos no coinciden.'],401); }
	}
}