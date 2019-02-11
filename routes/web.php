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
})->name('welcome');

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    //Tablero
	Route::get('/inicio', 'TableroController@inicio')->name('inicio');
    Route::post('/tablero/get_productos', 'TableroController@get_productos')->name('get_productos');

    /* usuario */
    Route::get('/usuario/editarInicio', 'PerfilController@editarInicio')->name('editarInicioPerfil');
    Route::post('/usuario/get_perfil', 'PerfilController@get_perfil')->name('get_perfil');
    Route::post('/usuario/set_perfil', 'PerfilController@set_perfil')->name('set_perfil');

    /* Rutas de noticias */
    Route::get('/noticias1', function () {
		return view('/noticias');
	});
	/* Rutas del dashboard */
	Route::get('/home', 'DashboardController@index')->name('home');
    Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');
	Route::post('addUnidadMedida', 'DashboardController@addUnidadMedida')->name('addUnidadMedida');
	Route::post('addProducto', 'DashboardController@addProducto')->name('addProducto');
    Route::post('addProyecto', 'DashboardController@addProyecto')->name('addProyecto');
	Route::post('iniciarSimulador', 'DashboardController@iniciarSimulador')->name('iniciarSimulador');
	/* Rutas del simulador */

    //Tutoriales
    Route::get('/simulador/tutoriales', function () {
		return view('/simulador/tutoriales/inicio');
    });
    Route::get('/simulador/inicio', 'SimuladorController@inicio')->name('inicioSimulador');
	Route::post('/simulador/getData', 'SimuladorController@getData')->name('getDataSimulador');
	Route::post('/simulador/calcularPrecioVenta', 'SimuladorController@calcularPrecioVenta')->name('calcularPrecioVenta');
	Route::post('/simulador/siguiente','SimuladorController@siguiente')->name('simSiguiente');
	/* Rutas de pronostico de ventas */
	Route::post('/simulador/regionObjetivo', 'PronosticoVentasController@regionObjetivo')->name('regionObjetivo');
	Route::post('/simulador/getSegmentacion', 'PronosticoVentasController@getSegmentacion')->name('getSegmentacion');
	Route::post('/simulador/getNivelSocioEco', 'PronosticoVentasController@getNivelSocioEco')->name('getNivelSocioEco');
	Route::post('/simulador/getMercDisp', 'PronosticoVentasController@getMercDisp')->name('getMercadoDisponible');
	Route::post('/simulador/getVista', 'PronosticoVentasController@getVista')->name('getVista');
	Route::post('/simulador/getProyeccion', 'PronosticoVentasController@getProyeccion')->name('getProyeccion');
	Route::post('/simulador/getMeses', 'PronosticoVentasController@getMeses')->name('getMeses');
	/* Rutas de Inventario */
	Route::get('/simulador/inventario','InventarioController@index')->name('inventario');
	Route::post('/simulador/guardarInventario', 'InventarioController@guardar')->name('guardarInventario');
	/* Rutas de Mercadotecnia */
	Route::get('simulador/mercadotecnia', 'MercadotecniaController@index')->name('mercadotecnia');
	/* Rutas de la guía */
	Route::post('guia', 'GuiaController@mostrarMensaje')->name('guia');
    /* Rutas del mensajero*/
    Route::get('/mensajero', function () {
		return view('/simulador/mensajero/mensajero');
	});
    Route::post('/mensajero/get_datos', 'MensajeroController@get_datos')->name('get_datos');
    Route::post('/mensajero/addMensaje', 'MensajeroController@addMensaje')->name('addMensaje');
    /* Rutas del Producto*/
    Route::get('/productomenu', 'ProductoController@index')->name('productomenu');
    Route::post('/producto/editarProducto', 'ProductoController@editarProducto')->name('editarProducto');
    Route::get('/producto/editarInicio','ProductoController@editarInicio')->name('editarInicioProducto');
    Route::post('/producto/get_producto', 'ProductoController@get_producto')->name('get_producto');
    Route::post('/producto/set_producto', 'ProductoController@set_producto')->name('set_producto');
    /* Rutas del TKT*/
    Route::get('/tkt/editarInicio', 'TktController@editarInicio')->name('editarInicioTkt');
    Route::post('/tkt/get_formulacion', 'TktController@get_formulacion')->name('get_formulacion');
    Route::post('/tkt/set_formulacion', 'TktController@set_formulacion')->name('set_formulacion');

    /* Rutas de Nomina*/
    Route::get('/nomina/editarInicio', 'NominaController@editarInicio')->name('editarInicioNomina');
    Route::post('/nomina/get_nomina', 'NominaController@get_nomina')->name('get_nomina');
    Route::post('/nomina/set_nomina', 'NominaController@set_nomina')->name('set_nomina');
    /* Rutas del Acumulado*/
    Route::get('/acumulado/editarInicio', 'AcumuladoController@editarInicio')->name('editarInicioAcumulado');
	Route::post('/acumulado/get_formulacion', 'AcumuladoController@get_acumulado')->name('get_acumulado');

	/* Rutas de mercadotecnia */
	Route::post('/simulador/guardarMercadotecnia', 'MercadotecniaController@guardarMercadotecnia')->name('guardarMercadotecnia');

    /* Rutas de inversión inicial*/
    Route::get('/inicial/editarInicio', 'InversioninicialController@editarInicio')->name('editarInicioInversion');
    Route::post('/inicial/get_inversion', 'InversioninicialController@get_inversion')->name('get_inversion');
    Route::post('/inicial/set_inversion', 'InversioninicialController@set_inversion')->name('set_inversion');

    /* Rutas de situación inicial*/
    Route::get('/inicial/editarInicioSituacion', 'SituacioninicialController@editarInicioSituacion')->name('editarInicioSituacion');
    Route::post('/inicial/get_situacion', 'SituacioninicialController@get_situacion')->name('get_situacion');
    Route::post('/inicial/set_situacion', 'SituacioninicialController@set_situacion')->name('set_situacion');

    /* Reportes*/
    Route::get('/reportes/perdidasganancias', 'ReportesController@perdidasganancias')->name('perdidasGanancias');
    Route::post('/reportes/get_perdidasganancias', 'ReportesController@get_perdidasganancias')->name('get_perdidasganancias');

    /* Avances de simulador */
    Route::post('/obtenAvanace', 'AvanceEtapasController@obtenAvance')->name('obtenAvanace')->name('obtenAvance');
    Route::post('/mostrarEtapa', 'AvanceEtapasController@mostrarEtapa')->name('mostrarEtapa');


});
Route::group(['middleware' => ['web']], function ()
{
	/*Route::resource('/prueba','PruebaController');
	Route::post('/grabar', 'PruebaController@store')->name('grabarprueba');*/
});
