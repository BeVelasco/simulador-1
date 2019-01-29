<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMercadotecniasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mercadotecnias', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_user')->unsigned(11);
			$table->foreign('id_user')->references('id')->on('users');
			$table->integer('id_producto')->unsigned(11)->nullable();
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->string('tipoMercadotecnia');
            $table->double('precio',20,4);
            $table->double('canalesDistribucion',20,4);
            $table->double('producto',20,4);
            $table->double('promocion',20,4);
            $table->double('relacionesPublicas',20,4);
            $table->double('clientesInternos',20,4);
            $table->double('total',20,4);

            $table->softdeletes();
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
        Schema::dropIfExists('mercadotecnias');
    }
}
