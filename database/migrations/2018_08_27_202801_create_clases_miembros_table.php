<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasesMiembrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clases_miembros', function (Blueprint $table) {
            $table->increments('id');

             //Clave foranea
            $table->integer('clase_id')->unsigned();
            $table->integer('miembro_id')->unsigned();

            //vinculaicion con tablas foraneas
            $table->foreign('clase_id')->references('id')->on('clases')->onDelete('cascade');
            $table->foreign('miembro_id')->references('id')->on('miembros')->onDelete('cascade');

            $table->enum('ocupacion', ['F','A','P']);
            $table->enum('asistencia', ['espera', 'si', 'no'])->default('espera');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clases_miembros');
    }
}
