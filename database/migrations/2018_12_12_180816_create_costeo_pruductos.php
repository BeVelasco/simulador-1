<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCosteoPruductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costeoProductos', function (Blueprint $table) {
            $table->increments('id');

            $table -> integer('id_user') -> unsigned(11);
            $table -> foreign('id_user') -> references('id')->on('users') -> onDelete('cascade');
            $table -> integer('id_producto') -> unsigned(11) -> nullable();
            $table -> foreign('id_producto') -> references('id')->on('productos') -> onDelete('cascade');
            $table -> text('data');
            $table -> text('dataPrecioVenta');
            $table -> double('PBBD', 11, 2);
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
        Schema::dropIfExists('costeoProductos');
    }
}
