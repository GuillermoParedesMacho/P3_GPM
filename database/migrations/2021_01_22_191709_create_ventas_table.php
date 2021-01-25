<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('Stock');
            $table->float('Precio',4,2);
            $table->unsignedBigInteger('Carta_ID');
            $table->unsignedBigInteger('Usuario_ID');
            $table->timestamps();

            $table->foreign('Carta_ID')->references('id')->on('cartas');
            $table->foreign('Usuario_ID')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
