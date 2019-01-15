<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosinsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productosinsumos', function (Blueprint $table) {
            $table->increments('id');

            $table -> integer('id_user') -> unsigned(11);
            $table -> integer('id_productos') -> unsigned(11) -> nullable();
            $table -> string('insumo')->comment('id_productos');
            $table -> string('unidad')->comment('id_productos');
            $table -> string('piezas')->comment('id_productos');
            $table -> string('um')->comment('id_productos');
            $table -> double('costo', 10, 2)->comment('id_productos');
            $table -> double('piezasxunidad', 10, 2)->comment('id_productos');
            $table -> double('unidadesconesapieza', 10, 2)->comment('id_productos');
            $table -> double('prodx1', 10, 2)->comment('id_productos');
            $table -> double('prodx2', 10, 2)->comment('id_productos');
            $table -> double('prodx3', 10, 2)->comment('id_productos');
            $table -> double('totalproduccion', 10, 2)->comment('id_productos');
            $table -> double('piezaser', 10, 2)->comment('id_productos');
            $table -> double('ventaser', 10, 2)->comment('id_productos');
            $table -> double('costoser', 10, 2)->comment('id_productos');
            $table -> double('totalser', 10, 2)->comment('id_productos');
            $table -> double('total', 10, 2)->comment('id_productos');
            $table -> double('tiempoensurtir', 10, 2)->comment('id_productos');
            
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
        Schema::dropIfExists('productosinsumos');
    }
}
