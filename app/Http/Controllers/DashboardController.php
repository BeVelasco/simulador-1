<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Catum, App\Producto, App\User;

use Auth, Session;

class DashboardController extends Controller
{
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		/* Obtengo el id del usuario */
		$idUser    = Auth::user() -> id;
		/* Obtiene los productos registrados por el usuario */
		$productos = User::find($idUser) -> productos() -> paginate(10);
		$totProd   = User::find($idUser) -> productos() -> count();
		/* Obtengo las UM ordenadas */
		$um        = Catum::all() -> sortBy('idesc');

		/* Return the view withe some needed variables */
		return view('home',[
			'unidadMedidas' => $um,
			'noProductos'   => $totProd,
			'productos'     => $productos,
			'noCatum'       => $um -> count(),
		]);
	}

	public function addUnidadMedida(Request $request)
	{
		/* Mensajes personalizados cuando hay errores en la validación */
		$messages = [
			'unique'   => 'La unidad de medida ya existe.',
			'required' => 'Debe ingresar el nombre de la unidad de medida.',
			'regex'    => 'El campo :attribute solo acepta letras.'
		];

		/* Reglas de validacion */
		$rules = [
			'descripcion' => ['required','max:50','unique:catums,idesc','regex:/^[0-9\pL\s\-]+$/u']
		];

		/* Se validan los datos con las reglas y mensajes especificados */
		$validate = \Validator::make($request->all(), $rules, $messages);

		/* Si la validación falla, regreso solamente el primer error. */
		if ($validate -> fails())
		{
			return response()->json([
				'status' => 'error',
				'msg'    => $validate->errors()->first()]);
		}

		/* Si la validación es correcta agrego la nueva UM a la BD */
		/* Sanitiza los datos y pone el primer caracter en mayuscula */
		$um    = ucfirst(strip_tags($request->descripcion));
		$catum = new Catum();

		/* Agrega los campos que son necesarios */
		$catum -> idesc =  $um;
		$catum -> save();
		
		/* Obtengo el total de unidades de medida existentes */
		$id = Catum::count();

		/* Regreso la respuesta exitosa con los datos para agregar al select la nueva opción */
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
	public function addProducto(Request $request)
	{
		/* Mensajes personalizados cuando hay errores en la validación */
		$messages = [
			'numeric'  => 'El valor de :attribute no corresponde a un número',
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
		$data = \Validator::make($request->all(), $rules, $messages);

		/* Si la validación falla, regreso solamente el primer error. */
		if ($data->fails())
		{
			return response()->json([
				'status' => 'error',
				'msg'    => $data->errors()->first()]);
		}

		/* Sanitiza los datos y pone el primer caracter en mayuscula */
		$desc    = ucfirst(strip_tags($request->descripcion));
		$um      = strip_tags($request->unidadMedida);
		$porcion = $request->porcion;

		/* Se verifica si la categoría existe en la BD, si no se encuentra
		   se manda un mensaje de error solicitando el refresco de la página */
		$res = Catum::find($um);
		if (!$res)
		{
			return response() -> json([
				'status' => 'error',
				'msg'    => 'No se encontró la unidad de medida, actualice la página.',
			]);
		}

		/* Obtiene el id del usuario */
		$idUser = Auth::user() -> id;

		/* Se agregan los valores enviados por el usuario y se guarda en la BD */
		$prod   = new Producto();
		$prod -> idesc          = $desc;
		$prod -> idcatnum1      = $um;
		$prod -> porcionpersona = $porcion;
		$prod -> id_user_r      = $idUser;
		$prod -> save();
		$porcion = $porcion.' - '.Catum::find($um)->idesc;
		/* Obtengo el id del producto guardado */
		$idProd = Producto::all()->last() -> id;

		/* Obtengo el total de productos que tiene registrado el usuario */
		$totProd = User::find($idUser) -> productos -> count();
		
		/* Regreso la respuesta exitosa con el total para actualizar el número en la vista  */
		return response() -> json([
			'status'  => 'success',
			'msg'     => 'Producto '.$desc.' agregado con exito.',
			'totProd' => $totProd,
			'desc'    => $desc,
			'porcion' => $porcion,
			'url'     => '<a href="javascript:comenzarSimulador('.$idProd.')"><button type="button" class="btn bg-black waves-effect waves-light">Comenzar simulador</button></a>'
		]);
	}

	public function iniciarSimulador(Request $request)
	{
		/* Mensajes personalizados cuando hay errores en la validación */
		$messages = [
			'exists'   => 'El :attribute no existe.',
			'required' => 'El campo :attribute es obligatorio.',
		];

		/* Reglas de validacion */
		$rules = [
			'iP' => ['required','exists:productos,id'],
		];

		/* Se validan los datos con las reglas y mensajes especificados */
		$validate = \Validator::make($request->all(), $rules, $messages);

		/* Si la validación falla, regreso solamente el primer error. */
		if ($validate -> fails())
		{
			return response()->json([
				'status' => 'error',
				'msg'    => $validate->errors()->first()]);
		}

		/* Verifica que el usuario esté logeado y coincida con el id que envió*/
		$idProd   = $request -> iP;
		$error    = ['status' => 'error','msg' => 'Datos no coinciden.'];
		$producto = Producto::find($idProd);

		if ( Auth::check() )
		{
			if (  $producto -> id_user_r == Auth::user() -> id )
			{
				/* Agrego a la sesión los datos del producto seleccionado */
				Session::put('prodSeleccionado', $producto);
				return response()->json([
					'status' => 'success',
					'msg'    => 'Correcto']);
			} else {
				/* El producto no es de el*/
				return response()->json([$error]);
			}
		} else { 
			/* Usuario no está logeado o los datos no coinciden*/
			return response()->json([$error]);
		}
	}
}
/*return response()->json([
					'status' => 'error',
					'msg'    => $producto]);*/