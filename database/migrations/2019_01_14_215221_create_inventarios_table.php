<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table -> increments('id');
            
            $table -> integer('id_user') -> unsigned(11);
            $table -> foreign('id_user') -> references('id')->on('users');
            $table -> integer('id_producto') -> unsigned(11) -> nullable();
            $table -> foreign('id_producto') -> references('id')->on('productos');
            $table -> integer('ventasAnuales');
            $table -> double('venPromMen',11,2);
            $table -> double('porInvFinDes',11,2);
            $table -> double('uniInvFinDes',11,2);
            $table -> double('valInvFinDes',11,2);

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
        Schema::dropIfExists('inventarios');
    }
}