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
            $table -> text('datos')->nulleable();
            $table -> double('sumanomina', 11, 2)->default(0);
            
            /*$table -> double('sueldode', 11, 2);
            $table -> double('sueldoa', 11, 2);
            $table -> double('salariopagar', 11, 2);
            $table -> double('numerotrabajadores', 11, 2);
            $table -> double('salariototalmes', 11, 2);
            $table -> double('salariototalantes', 11, 2);
            $table -> double('primavacacional', 11, 2);
            $table -> double('aguinaldoanual', 11, 2);
            $table -> double('salariototaldesp', 11, 2);
            $table -> double('seguridadsocial', 11, 2);
            $table -> double('fondonacional', 11, 2);
            $table -> double('ahorroretiro', 11, 2);
            $table -> double('totalimpuestos', 11, 2);
            $table -> double('totalimporte', 11, 2);*/
            
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
