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
	Route::get('/home', 'DashboardController@index')->name('home');
	Route::post('addUnidadMedida', 'DashboardController@addUnidadMedida')->name('addUnidadMedida');
	Route::post('addProducto', 'DashboardController@addProducto')->name('addProducto');
	Route::post('inciarSimulador', 'DashboardController@iniciarSimulador')->name('iniciarSimulador');

	/* Rutas del simulador */
	Route::get('/simulador/inicio', 'SimuladorController@inicio')->name('inicioSimulador');
	
	/* Rutas de la guía */
	Route::post('guia', 'GuiaController@mostrarMensaje')->name('guia');
});
Route::group(['middleware' => ['web']], function ()
{
	
});
