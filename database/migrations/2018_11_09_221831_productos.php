<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Productos extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('productos', function (Blueprint $table) {
			$table -> increments('id');

			$table -> string('idesc',100); //Descripcion del producto
			$table -> char('state', 1) -> default('A'); //Estado del producto

			$table -> integer('id_user_r') -> unsigned(11) -> nullable();//Id del usuario que crea el producto
			$table -> foreign('id_user_r') -> references('id') -> on('users');

			//Id de la unidad de medida
			$table -> integer('idcatnum1') -> unsigned(11) -> nullable();
			$table -> foreign('idcatnum1') -> references('id')->on('catums');
			$table -> integer('idcatnum2') -> unsigned(11) -> nullable();
			$table -> foreign('idcatnum2') -> references('id')->on('catums');
			$table -> integer('idcatnum3') -> unsigned(11) -> nullable();
			$table -> foreign('idcatnum3') -> references('id')->on('catums');

			$table -> double('porcionpersona',8, 2); //Para cuantas personas es su producto
			$table -> string('icode',10) -> nullable();

			$table -> softDeletes();
			$table -> timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('productos');
	}
}
