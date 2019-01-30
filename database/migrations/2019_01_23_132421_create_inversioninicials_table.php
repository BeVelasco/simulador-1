<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInversioninicialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inversioninicials', function (Blueprint $table) {
            $table -> increments('id');
            
            $table -> integer('id_user') -> unsigned(11);
            $table -> foreign('id_user') -> references('id')->on('users');
            $table -> double('efectivo',11,2);
            $table -> double('cuentasxcobrar',11,2);
            $table -> double('cuentasxpagar',11,2);
            $table -> double('impuestosxpagar',11,2);
            $table -> double('capitaltrabajoneto',11,2);
            
            $table -> double('equipooficina',11,2);
            $table -> double('plantamaquinaria',11,2);
            $table -> double('maquinariaequipo',11,2);
            $table -> double('equipotransporte',11,2);
            $table -> double('intangibles',11,2);
            
            $table -> double('gastosconstitucion',11,2);
            $table -> double('gastosasesoria',11,2);
            $table -> double('gastospuesta',11,2);
            $table -> double('reclutamiento',11,2);
            $table -> double('segurospagados',11,2);
            $table -> double('promocion',11,2);
            $table -> double('gastosinstalacion',11,2);
            $table -> double('papeleria',11,2);

            $table -> double('totalinversion',11,2);
            $table -> double('totalotrosactivos',11,2);
            $table -> double('totalactivosnocirculantes',11,2);
            
            
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
        Schema::dropIfExists('inversioninicials');
    }
}