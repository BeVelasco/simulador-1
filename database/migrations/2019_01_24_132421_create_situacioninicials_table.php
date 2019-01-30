<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSituacioninicialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('situacioninicials', function (Blueprint $table) {
            $table -> increments('id');
            
            $table -> integer('id_user') -> unsigned(11);
            $table -> foreign('id_user') -> references('id')->on('users');
            $table -> double('prestamoaccionistas',11,2);
            $table -> double('prestamolargoplazo',11,2);
            $table -> double('inversionaccionistas',11,2);
            $table -> double('utilidadreservas',11,2);
            $table -> double('porcgastos2',11,2);
            $table -> double('porcgastos3',11,2);
            
            $table -> double('oficinas',11,2);
            $table -> double('servpublicos',11,2);
            $table -> double('telefonos',11,2);
            $table -> double('seguros',11,2);
            $table -> double('papeleria',11,2);
            $table -> double('rentaequipo',11,2);
            $table -> double('costoweb',11,2);
            $table -> double('costoconta',11,2);
            
            $table -> double('honorariolegal',11,2);
            $table -> double('viajesysubsistencia',11,2);
            $table -> double('gastosautos',11,2);
            $table -> double('gastosgenerales',11,2);
            $table -> double('cargosbancarios',11,2);
            $table -> double('otrosservicios',11,2);
            $table -> double('gastosinvestigacion',11,2);
            $table -> double('gastosdiversos',11,2);

            $table -> double('tasalider',11,2);
            $table -> double('primariesgo',11,2);
            $table -> double('riesgopais',11,2);
            
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
        Schema::dropIfExists('situacioninicials');
    }
}