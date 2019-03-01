<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clase_miembro extends Model
{
    protected $table      = 'clases_miembros';
	protected $primaryKey = 'id';
	public $timestamps    = false;
    protected $fillable   = [
    	'clase_id', 'miembro_id', 'ocupacion', 'asistencia'
    ];
}
