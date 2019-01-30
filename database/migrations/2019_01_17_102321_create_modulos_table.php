<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table -> increments('id');
            
            $table -> string('idesc');
            $table -> string('icode')->default('');
            $table -> integer('orden');
            $table -> string('dependientes');
            $table -> tinyinteger('particular')->comment('El campo es particular o general para todos los productos');

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
        Schema::dropIfExists('modulos');
    }
}