<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasMensualesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_mensuales', function (Blueprint $table) {
            $table -> increments('id');
            
            $table -> integer('id_user') -> unsigned(11);
            $table -> foreign('id_user') -> references('id') -> on('users');
            $table -> integer('id_producto') -> unsigned(11) -> nullable();
            $table -> foreign('id_producto') -> references('id') -> on('productos');
            $table -> string('mes');
            $table -> double('porcentaje', 11, 2);
            $table -> double('unidades', 11, 2);
            $table -> double('precioVenta', 11, 2);
            $table -> double('total', 15, 2);

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
        Schema::dropIfExists('ventas_mensuales');
    }
}
