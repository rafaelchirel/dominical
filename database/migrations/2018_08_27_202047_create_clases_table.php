<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('descripcion');
            $table->date('fecha');
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->float('ofrenda',12,2)->default(0);
            $table->boolean('impartida')->default(0);

            //Clave foranea
            $table->integer('grupo_id')->unsigned();

            //vinculaicion con tablas foraneas
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clases');
    }
}
