<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table      = 'bitacora';
	protected $primaryKey = 'id';
	public $timestamps    = false;
    protected $fillable   = [
    	'fecha_hora', 'accion', 'descripcion', 'user_id'
    ];

    protected $guarded = [];
}
