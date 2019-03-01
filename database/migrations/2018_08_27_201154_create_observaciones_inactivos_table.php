<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObservacionesInactivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observaciones_inactivos', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('fecha_hora');
            $table->string('descripcion');

            //Clave foreana
            $table->integer('miembro_id')->unsigned();

            //vinculaicion con tablas foraneas
            $table->foreign('miembro_id')->references('id')->on('miembros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('observaciones_inactivos');
    }
}
