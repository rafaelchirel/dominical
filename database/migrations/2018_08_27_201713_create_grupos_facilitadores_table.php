<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGruposFacilitadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos_facilitadores', function (Blueprint $table) {
            $table->increments('id');
            
            //Clave foreana
            $table->integer('grupo_id')->unsigned();
            $table->integer('miembro_id')->unsigned();

            //vinculaicion con tablas foraneas
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade');
            $table->foreign('miembro_id')->references('id')->on('miembros')->onDelete('cascade');

            $table->enum('ocupacion',['F','A']);
            $table->enum('turno',['M','T','N']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grupos_facilitadores');
    }
}
