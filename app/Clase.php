<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clase extends Model
{
    use SoftDeletes;

	protected $table      = 'clases';
	protected $primaryKey = 'id';
	public $timestamps    = false;
    protected $fillable   = [
    	'nombre', 
    	'descripcion', 
    	'fecha', 
    	'hora_entrada', 
    	'hora_salida', 
    	'ofrenda', 
    	'impartida', 
    	'grupo_id', 
    	'deleted_at'
    ];

    protected $guarded = [];
    protected $dates = ['deleted_at'];

    //mutators / Set
    public function setNombreAttribute($value) {
        $this->attributes['nombre'] = strtolower($value);
    }

    public function setDescripcionAttribute($value) {
        $this->attributes['descripcion'] = strtolower($value);
    }

    //mutators / get
    public function getNombreAttribute($value)
    {
       return ucfirst($value);
    }

    public function getDescripcionAttribute($value)
    {
       return ucfirst($value);
    }
}
