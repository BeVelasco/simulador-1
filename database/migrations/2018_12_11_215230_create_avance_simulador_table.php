<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvanceSimuladorTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('avancesimulador', function (Blueprint $table) {
			$table -> increments('id');

			$table -> string('seccion');
			$table -> boolean('realizado');
			$table -> integer('id_user') -> unsigned(11);
			$table -> foreign('id_user') -> references('id')->on('users');
			$table -> integer('id_producto') -> unsigned(11) -> nullable();
			$table -> foreign('id_producto') -> references('id')->on('productos');

			$table -> softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('avancesimulador');
	}
}
