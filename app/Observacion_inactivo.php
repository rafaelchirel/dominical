<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Observacion_inactivo extends Model
{
    protected $table      = 'observaciones_inactivos';
	protected $primaryKey = 'id';
	public $timestamps    = false;
    protected $fillable   = [
    	'fecha_hora', 'descripcion', 'miembro_id'
    ];

    protected $guarded = [];

    public function setDescripcionAttribute($value) {
        $this->attributes['descripcion'] = strtolower($value);
    }
}
