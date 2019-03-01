<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObservacionesClasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observaciones_clases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');

            //Clave foranea
            $table->integer('clase_id')->unsigned();

            //vinculaicion con tablas foraneas
            $table->foreign('clase_id')->references('id')->on('clases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('observaciones_clases');
    }
}
