<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegionObjetivoRequest;
use App\Http\Requests\SegmentacionRequest;
use Auth;
use View;
use Lang;
use Session;
use URL;

class PronosticoVentasController extends Controller
{
	private $messages = [
		'required' => 'El campo :attribute es obligatorio',
		'numeric'  => 'El valor de :attribute debe ser numérico',
		'between'  => 'El valor de :attribute debe estar entre 1 y 99'
	];
	private $meses = [1  => 'Enero',2  => 'Febrero',3  => 'Marzo',4  => 'Abril',5  => 'Mayo',6  => 'Junio',
		7  => 'Julio',8  => 'Agosto',9  => 'Septiembre',10 => 'Octubre',11 => 'Noviembre',12 => 'Diciembre',
	];

	/**
	 * Captura y guarda la region objetivo en la sesión.
	 *
	 * @param RegionObjetivoRequest $request
	 * @return Response
	 */
	public function regionObjetivo(RegionObjetivoRequest $request)
	{
		$totalPersonas  = ($request->personas * $request->porcentaje)/100;
		$regionObjetivo = [
			"estado"         => $request->estado,
			"personas"       => $request->personas,
			"ciudadObjetivo" => $request->ciudadObjetivo,
			"porcentaje"     => $request->porcentaje,
			"totalPersonas"  => $totalPersonas
		];
		Session::put('regionObjetivo', $regionObjetivo);
		return response()->json([
			'message'          => Lang::get('messages.numTotalPersonas'),
			'text'             => Lang::get('messages.metodoUsa'),
			'pea'              => Lang::get('messages.pea'),
			'spg'              => Lang::get('messages.spg'),
			'spe'              => Lang::get('messages.spe'),
			'seleccioneMetodo' => Lang::get('messages.seleccioneMetodo'),
			'tieneSelVal'      => Lang::get('messages.tieneSelVal'),
			'totalPersonas'    => $totalPersonas
		],200);
	}

	/**
	 * Obtiene la vista de la segmentacion solicitada
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function getSegmentacion(SegmentacionRequest $request){	
		$seg = $request -> segmentacion;
		switch ($seg) {
			case 'pea':$ndfgt='simulador.segmentaciones.pea';break;				
			case 'spg':$ndfgt='simulador.segmentaciones.spg';break;				
			case 'spe':$ndfgt='simulador.segmentaciones.spe';break;
			default:
				return response()->json([
					'errors' => [
						'segmentacion' => [
							0 => Lang::get('messages.segmNoExiste')
						]
					]
				],400);break;
		}
		$seg = obtenVista($ndfgt);
		return response() -> json(['segmentacion' => $seg],200);
	}
	
	public function getVista(Request $request) {
		$vistaEnviada = $request -> vista;
		$var = null;
		switch ( $vistaEnviada ){
			case 'ProyVen':
				$respuesta = guardaEstimDemanda($request);
				if ($respuesta != 'true') return response() -> json(["message" => $respuesta],400);
				$vista = obtenVista('simulador.segmentaciones.proyeccionVenta');
				$var   = obtenYear();
			break;
			case 'EstimDem':
				$respuesta = guardaNivelSocioEco($request, $this -> messages);
				if ($respuesta != 'true') return response() -> json(["message" => $respuesta],400);
				$vista = obtenVista('simulador.segmentaciones.mercadoDisponible');
			break;
			case 'NivelSocioEco':
				$respuesta = guardaSegmentacion($request, $this -> messages);
				if ($respuesta != 'true') return response() -> json(["message" => $respuesta],400);
				$vista = obtenVista('simulador.segmentaciones.nse');
			break;
			case 'Inventario':
				$respuesta = guardaProyeccionVentas($request);
				if ($respuesta != 'true') return response() -> json(["message" => $respuesta],400);
				$respuesta = guardaPronosticoVenta();
				if ($respuesta != 'true') return response() -> json(["message" => $respuesta],400);
				$respuesta = guardaVentasMensuales();
				if ($respuesta != 'true') return response() -> json(["message" => $respuesta],400);
				$guardaEtapa = terminarEtapa(Auth::user()->id,Session::get('prodSeleccionado'), 2);
				if ($guardaEtapa == "true"){return response() -> json(['var'=>'etapa3','ruta'=>URL::route('inventario'),]);}else{return response()->json(["message"=>$guardarEtapa],401);}
			break;
			default:return response()->json(['message'=>Lang::get('messages.vistaNoExiste')]);break;
		}
		$li    =  'li'.$vistaEnviada;
		$panel = '#contenidopanel'.$vistaEnviada;
		return response()->json(['vista'=>$vista,'li'=>$li,'panel'=>$panel,'var'=>$var,], 200);
	}
	public function getMeses(Request $request){
		$mesInicio = $request -> mesInicio;
		for ( $i=1;$i<13;$i++ ){$a[$i]=$this->meses[$mesInicio];$mesInicio == 12 ? $mesInicio = 1 : $mesInicio++;}
		$ventasMensuales['meses'] = $a;
		Session::put('ventasMensuales', $ventasMensuales);
		Session::put('mesInicio', $ventasMensuales['meses'][1]);
		return  response()->json(['meses' => $a], 200);
	}

	public function getProyeccion(Request $request){
		$idProducto  = Session::get('prodSeleccionado');
		$variables   = $request['variables'];
		$creVen      = $request -> creVen;
		$crePob      = $request -> crePob;
		$year        = obtenYear();
		$year        = $year['actual'];
		$proy[0]     = ['1'=>$variables['mercadoPotencial']*1,'2'=>$variables['mercadoDisponible']*1,'3'=>$variables['mercadoEfectivo']*1,'4'=>$variables['mercadoObjetivo']*1,'5'=>$variables['consumoAnual']*1,];
		$precioVenta = obtenPrecioVenta($idProducto);
		for ( $i=1;$i<4;$i++ ){
			$proy[$i] = [
				'1' => (($proy[$i-1][1]*$crePob )/100)+$proy[$i-1][1],
				'2' => (($proy[$i-1][2]*$crePob )/100)+$proy[$i-1][2],
				'3' => (($proy[$i-1][3]*$crePob )/100)+$proy[$i-1][3],
				'4' => (($proy[$i-1][4]*$creVen )/100)+$proy[$i-1][4],
				'5' => (($proy[$i-1][5]*$creVen )/100)+$proy[$i-1][5],
			];
		}
		return response() -> json (['var'=>$proy,'year'=>$year,'meses'=>$this->meses,'precioVenta'=>$precioVenta,],200);
	}
}