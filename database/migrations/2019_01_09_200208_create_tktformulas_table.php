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
            $table -> text('proceso')->nulleable();
            $table -> double('sumatakttime', 11, 2)->default(0);
            
            $table -> string('tiempo');
            $table -> string('cantidad');
            $table -> string('insumos');
            $table -> string('personas');
            $table -> string('maquinaria');
            $table -> string('herramienta');
            $table -> double('check1', 11, 2);
            $table -> double('check2', 11, 2);
            $table -> double('check3', 11, 2);
            $table -> double('check4', 11, 2);
            $table -> double('check5', 11, 2);
            $table -> double('promedio', 11, 2);
            $table -> string('analisisempleado');
            $table -> double('porcmedicionempleado', 11, 2);
            $table -> double('porcmedicionmaquinaria', 11, 2);
            
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
