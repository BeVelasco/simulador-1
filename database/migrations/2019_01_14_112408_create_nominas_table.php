<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNominasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominas', function (Blueprint $table) {
            $table->increments('id');

            $table -> integer('id_user') -> unsigned(11);
            //$table -> integer('id_productos') -> unsigned(11) -> nullable();
            $table -> double('sueldode', 10, 2);
            $table -> double('sueldoa', 10, 2);
            $table -> double('salariopagar', 10, 2);
            $table -> double('numerotrabajadores', 10, 2);
            $table -> double('salariototalmes', 10, 2);
            $table -> double('salariototalantes', 10, 2);
            $table -> double('primavacacional', 10, 2);
            $table -> double('aguinaldoanual', 10, 2);
            $table -> double('salariototaldesp', 10, 2);
            $table -> double('seguridadsocial', 10, 2);
            $table -> double('fondonacional', 10, 2);
            $table -> double('ahorroretiro', 10, 2);
            $table -> double('totalimpuestos', 10, 2);
            $table -> double('totalimporte', 10, 2);
            
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
        Schema::dropIfExists('nominas');
    }
}
