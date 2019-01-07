<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePruebaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prueba', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entrance_id');
            $table->integer('user_id')->nullable()->default(null);
            $table->integer('floor');
            $table->integer('apt_number');
            $table->string('square_meters', 64)->nullable();
            $table->decimal('percent_ideal_parts', 10, 3)->nullable();
            $table->decimal('starting_balance', 8, 2);
            $table->string('animals', 200)->nullable();
            $table->string('other_information', 2048)->nullable();
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
        Schema::dropIfExists('prueba');
    }
}
