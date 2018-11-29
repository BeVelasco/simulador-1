<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catums', function (Blueprint $table) {
            $table -> increments('id');

            $table -> string('idesc', 50) -> unique()-> required();//descripcion de la unidad de medida
            $table -> string('icode', 10) -> nullable();
            $table -> char('state', 1) -> default('a');
            
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
        Schema::dropIfExists('catums');
    }
}
