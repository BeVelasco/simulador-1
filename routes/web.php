<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    /*Panel de control*/
    Route::get('/inicio', function () {
		return view('/simulador/dashboard/inicio');//return view('/noticias');
	});
    /* Rutas de noticias */
    Route::get('/noticias1', function () {
		return view('/noticias');
	});
	/* Rutas del dashboard */
	Route::get('/home', 'DashboardController@index') -> name('home');
    Route::get('/dashboard', 'DashboardController@dashboard') -> name('dashboard');
	Route::post('addUnidadMedida', 'DashboardController@addUnidadMedida') -> name('addUnidadMedida');
	Route::post('addProducto', 'DashboardController@addProducto') -> name('addProducto');
	Route::post('iniciarSimulador', 'DashboardController@iniciarSimulador') -> name('iniciarSimulador');
	/* Rutas del simulador */
    //Tablero
	Route::get('/simulador/inicio', 'SimuladorController@inicio') -> name('inicioSimulador');
    //Tutoriales
    Route::get('/simulador/tutoriales', function () {
		return view('/simulador/tutoriales/inicio');
	});
	Route::post('/simulador/getData', 'SimuladorController@getData') -> name('getDataSimulador');
	Route::post('/simulador/calcularPrecioVenta', 'SimuladorController@calcularPrecioVenta') -> name('calcularPrecioVenta');
	Route::post('/simulador/siguiente','SimuladorController@siguiente') -> name('simSiguiente');
	/* Rutas de pronostico de ventas */
	Route::post('/simulador/regionObjetivo', 'PronosticoVentasController@regionObjetivo') -> name('regionObjetivo');
	Route::post('/simulador/getSegmentacion', 'PronosticoVentasController@getSegmentacion') -> name('getSegmentacion');
	Route::post('/simulador/getNivelSocioEco', 'PronosticoVentasController@getNivelSocioEco') -> name('getNivelSocioEco');
	Route::post('/simulador/getMercDisp', 'PronosticoVentasController@getMercDisp') -> name('getMercadoDisponible');
	Route::post('/simulador/getVista', 'PronosticoVentasController@getVista') -> name('getVista');
	Route::post('/simulador/getProyeccion', 'PronosticoVentasController@getProyeccion') -> name('getProyeccion');
	Route::post('/simulador/getMeses', 'PronosticoVentasController@getMeses') -> name('getMeses');
	/* Rutas de Inventario */
	Route::get('/simulador/inventario','InventarioController@index') -> name('inventario');
	Route::post('/simulador/guardarInventario', 'InventarioController@guardar') -> name('guardarInventario');
	/* Rutas de Mercadotecnia */
	Route::get('simulador/mercadotecnia', 'MercadotecniaController@index') -> name('mercadotecnia');
	/* Rutas de la guía */
	Route::post('guia', 'GuiaController@mostrarMensaje') -> name('guia');
    /* Rutas del mensajero*/
    Route::get('/mensajero', function () {
		return view('/simulador/mensajero/mensajero');
	});
    Route::post('/mensajero/get_datos', 'MensajeroController@get_datos') -> name('get_datos');
    Route::post('/mensajero/addMensaje', 'MensajeroController@addMensaje') -> name('addMensaje');
    /* Rutas del Producto*/
    Route::get('/productomenu', 'ProductoController@index') -> name('productomenu');
    Route::post('/producto/editarProducto', 'ProductoController@editarProducto') -> name('editarProducto');
    Route::get('/producto/editarInicio','ProductoController@editarInicio') -> name('editarInicio');
    Route::post('/producto/get_producto', 'ProductoController@get_producto') -> name('get_producto');
    Route::post('/producto/set_producto', 'ProductoController@set_producto') -> name('set_producto');
    /* Rutas del TKT*/
    Route::get('/tkt/editarInicio', 'TktController@editarInicio') -> name('editarInicio');
    Route::post('/tkt/get_formulacion', 'TktController@get_formulacion') -> name('get_formulacion');
    /* Rutas de Nomina*/
    Route::get('/nomina/editarInicio', 'NominaController@editarInicio') -> name('editarInicio');
    Route::post('/nomina/get_nomina', 'NominaController@get_nomina') -> name('get_nomina');
    Route::post('/nomina/set_nomina', 'NominaController@set_nomina') -> name('set_nomina');
    /* Rutas del Acumulado*/
    Route::get('/acumulado/editarInicio', 'AcumuladoController@editarInicio') -> name('editarInicio');
    Route::post('/acumulado/get_formulacion', 'AcumuladoController@get_acumulado') -> name('get_acumulado');
    
});
Route::group(['middleware' => ['web']], function ()
{

});
