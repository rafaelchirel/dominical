<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    protected $table      = 'observaciones';
	protected $primaryKey = 'id';
	public $timestamps    = false;
    protected $fillable   = [
    	'descripcion', 'clase_miembro_id'
    ];

    protected $guarded = [];
}
