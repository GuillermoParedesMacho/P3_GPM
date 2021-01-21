<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartaColeccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carta_coleccions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Carta_ID');
            $table->foreign('Carta_ID')->references('id')->on('cartas');
            $table->unsignedBigInteger('Coleccion_ID');
            $table->foreign('Coleccion_ID')->references('id')->on('coleccions');
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
        Schema::dropIfExists('carta_coleccions');
    }
}
