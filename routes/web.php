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
	/* Rutas del dashboard */
	Route::get('/home', 'DashboardController@index') -> name('home');
    Route::get('/dashboard', 'DashboardController@dashboard') -> name('dashboard');
	Route::post('addUnidadMedida', 'DashboardController@addUnidadMedida') -> name('addUnidadMedida');
	Route::post('addProducto', 'DashboardController@addProducto') -> name('addProducto');
	Route::post('inciarSimulador', 'DashboardController@iniciarSimulador') -> name('iniciarSimulador');

	/* Rutas del simulador */
	Route::get('/simulador/inicio', 'SimuladorController@inicio') -> name('inicioSimulador');
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
    Route::get('/producto/editarInicio', function () {
		return view('/simulador/producto/producto');
	});
    
    Route::post('/producto/get_producto', 'ProductoController@get_producto') -> name('get_producto');
    
});
Route::group(['middleware' => ['web']], function ()
{
	Route::resource('/prueba','PruebaController');
	Route::post('/grabar', 'PruebaController@store') -> name('grabarprueba');
});
