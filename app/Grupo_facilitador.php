<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo_facilitador extends Model
{
    protected $table      = 'grupos_facilitadores';
	protected $primaryKey = 'id';
	public $timestamps    = false;
    protected $fillable   = [
    	'grupo_id', 'miembro_id', 'ocupacion', 'turno'
    ];

    protected $guarded = [];
}
