<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grupo extends Model
{
    use SoftDeletes;

	protected $table      = 'grupos';
	protected $primaryKey = 'id';
	public $timestamps    = false;
    protected $fillable   = [
    	'nombre', 
    	'descripcion', 
    	'edad_ini', 
    	'edad_fin', 
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

    //scope
    public function scopeSearch($query, $search) {
        if ($search) return $query->Where('nombre', 'LIKE', "%{$search}%");
        return $query;
    }
}
