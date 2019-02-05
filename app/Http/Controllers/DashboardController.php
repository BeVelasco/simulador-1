<?php namespace App\Http\Controllers;
/**
 * Este archivo forma parte del Simulador de Negocios.
 *
 * (c) Emmanuel Hernández <emmanuelhd@gmail.com>
 * 
 *  Enero - 2019
 */

use Illuminate\Http\Request;
use Auth;
use Session;
use Lang;
use Simulador;
use App\Http\Requests\UnidadDeMedidaRequest;
use App\Http\Requests\ProductoNuevoRequest;
use App\Http\Requests\IniciarSimuladorRequest;
use App\Catum;
use App\Producto;
use App\User;
use App\Etapa;
use App\Pronostico;

class DashboardController extends Controller
{
	/**
	 * Muestra la página  con sus productos al usuario.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
    	Simulador::deleteSessionVariables();
		return view('home',[
			'unidadMedidas' => Catum::getCatumSortBy('idesc'),
			'noProductos'   => Producto::getTotalProducts(Auth::user()->id),
			'productos'     => Producto::getProductosPaginated(Auth::user()->id, 10),
			'noCatum'       => Catum::getCatumCount(),
			'proyecto'      => User::find(Auth::user()->id)->proyecto
		]);
	}

	/**
	 * Agrega una Unidad de Medida nueva
	 *
	 * @param UnidadDeMedidaRequest $request
	 * 
	 * @return void
	 */
	public function addUnidadMedida(UnidadDeMedidaRequest $request)
	{
		$um    = ucfirst(strip_tags($request->descripcion));
		$catum = new Catum();
		try 
		{
			$catum->idesc = $um;
			$catum->save();
		}
		catch (Exception $e)
		{
			return response()->json(['message' => $e->getMessage()], 401);
		}
		$val = Catum::count();
		return response()->json([
			'message' =>  str_replace("%um%", $um, Lang::get('validacion.umAgregada')),
			'option'  => $um,
			'val'     => $val
		]);
	}

	/**
	 * Agrega un producto nuevo a la Base de Datos
	 *
	 * @param ProductoNuevoRequest $request
	 * @return Response
	 */
	public function addProducto(ProductoNuevoRequest $request)
	{
		$desc    = ucfirst(strip_tags($request->descripcion));
		$um      = strip_tags($request->unidadMedida);
		$porcion = $request->porcion;
		$idUser  = Auth::user()->id;
		$existe  = Producto::checkProductExists($idUser, $desc);
		if ($existe != 0)
		{
			return response()->json([
				'message'=> str_replace("%prod%", $desc, Lang::get('validacion.prodExisteUsuario'))
			],401);
		}
		try {
			$prod                 = new Producto();
			$prod->idesc          = $desc;
			$prod->idcatnum1      = $um;
			$prod->porcionpersona = $porcion;
			$prod->id_user_r      = $idUser;
			$prod->save();
		} 
		catch (Exception $e) 
		{ 
			return response()->json(['message'=>$e->getMessage()], 401);	
		}
		/* Creo el botón que se agregará al HTML */
		$boton = obtenVista('simulador.componentes.boton');
		/* Inserta el id del producto creado en el nuevo botón */
		$boton = str_replace("%id%", Producto::all()->last()->id, $boton);
		return response()->json([
			'message' =>  str_replace("%prod%", $desc, Lang::get('validacion.prodAgregado')),
			'totProd' => Producto::getTotalProducts($idUser),
			'desc'    => $desc,
			'porcion' => $porcion.' - '.Catum::find($um)->idesc,
			'boton'   => $boton
		], 200);
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

	public function iniciarSimulador(IniciarSimuladorRequest $request)
	{	
		$idProd   = $request->iP;
		$producto = Producto::find($idProd);
		if ($producto == null)
		{
			return response()->json(['message' => Lang::get('validacion.iniSimIpExists')],401);
		}
		if ($producto->id_user_r == Auth::user()->id)
		{
			Session::put('prodSeleccionado', $producto->id);
			return response()->json(200);
		} else { 
			return response()->json(['message' => Lang::get('validacion.iniSimProdMal')],401); 
		}
	}
}
