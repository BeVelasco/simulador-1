<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDoubleValuesInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventarios', function($table) {
            $table->decimal('venPromMen',20,10)->change();
            $table->decimal('porInvFinDes',20,10)->change();
            $table->decimal('uniInvFinDes',20,10)->change();
            $table->decimal('valInvFinDes',20,10)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventarios', function($table) {
            $table->decimal('venPromMen',11,2)->change();
            $table->decimal('porInvFinDes',11,2)->change();
            $table->decimal('uniInvFinDes',11,2)->change();
            $table->decimal('valInvFinDes',11,2)->change();
        });
    }
}
