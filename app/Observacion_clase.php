<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Observacion_clase extends Model
{
    protected $table      = 'observaciones_clases';
	protected $primaryKey = 'id';
	public $timestamps    = false;
    protected $fillable   = [
    	'descripcion', 'clase_id'
    ];

    protected $guarded = [];
}
