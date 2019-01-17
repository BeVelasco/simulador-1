<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTktformulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tktformulas', function (Blueprint $table) {
            $table->increments('id');

            $table -> integer('id_user') -> unsigned(11);
            $table -> integer('id_productos') -> unsigned(11) -> nullable();
            $table -> string('proceso');
            $table -> string('tiempo');
            $table -> string('cantidad');
            $table -> string('insumos');
            $table -> string('personas');
            $table -> string('maquinaria');
            $table -> string('herramienta');
            $table -> double('check1', 10, 2);
            $table -> double('check2', 10, 2);
            $table -> double('check3', 10, 2);
            $table -> double('check4', 10, 2);
            $table -> double('check5', 10, 2);
            $table -> double('promedio', 10, 2);
            $table -> string('analisisempleado');
            $table -> double('porcmedicionempleado', 10, 2);
            $table -> double('porcmedicionmaquinaria', 10, 2);
            
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
        Schema::dropIfExists('tktformulas');
    }
}
