<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePronosticosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('pronosticos', function (Blueprint $table) {
            $table->increments('id');

            $table -> integer('id_user') -> unsigned(11);
            $table -> foreign('id_user') -> references('id')->on('users');
            $table -> integer('id_producto') -> unsigned(11) -> nullable();
            $table -> foreign('id_producto') -> references('id')->on('productos');
            
            $table -> double('regionObjetivo');
            $table -> text('regionObjetivo');
            $table -> text('totalPersonas');
            $table -> text('segmentacion');
            $table -> text('poblacionNeta');
            $table -> text('nivelSocioeconomico');
            $table -> text('mercadoPotencial');
            $table -> text('estimacionDemanda');
            $table -> text('mercadoDisponible');
            $table -> text('mercadoEfectivo');
            $table -> text('mercadoObjetivo');
            $table -> text('consumoAnual');
            $table -> text('proyeccionVentas');
            $table -> double('totalUnidades');

            $table -> softDeletes();
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('pronosticos');
    }
}
