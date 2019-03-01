<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiembrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miembros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cedula', 13);
            $table->string('nombre', 100);
            $table->string('apellido',100);
            $table->enum('genero', ['F', 'M']);
            $table->date('fecha_nac');
            $table->string('email')->nullable();
            $table->string('telefono', 11);
            $table->string('direccion');
            $table->enum('tipo', ['F','P','FP']);//Facilitador - Participante - FacilitadorParticipante
            $table->enum('condicion',['invitado', 'activo', 'inactivo']);
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
        Schema::dropIfExists('miembros');
    }
}
