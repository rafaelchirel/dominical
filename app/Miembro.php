<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Miembro extends Model
{
    use SoftDeletes;

	protected $table      = 'miembros';
	protected $primaryKey = 'id';
	public $timestamps    = false;
    protected $fillable   = [
    	'cedula', 
    	'nombre', 
    	'apellido', 
    	'genero', 
    	'fecha_nac', 
    	'email', 
    	'telefono', 
    	'direccion', 
    	'tipo',
    	'condicion',
    	'deleted_at'
    ];

    protected $guarded = [];
    protected $dates = ['deleted_at'];

    //mutators / get
    public function getNombreAttribute($value)
    {
       return ucfirst($value);
    }

    public function getApellidoAttribute($value)
    {
       return ucfirst($value);
    }
    /*
    public function getFechaNacAttribute($value)
    {
      return Carbon::createFromDate(Carbon::parse($value)->format('Y'),Carbon::parse($value)->format('m'),Carbon::parse($value)->format('d'))->age;
    }
    */

    //mutators / Set
    public function setCedulaAttribute($value) {
        $this->attributes['cedula'] = strtoupper($value);
    }

    public function setNombreAttribute($value) {
        $this->attributes['nombre'] = strtolower($value);
    }

    public function setApellidoAttribute($value) {
        $this->attributes['apellido'] = strtolower($value);
    }

    public function setEmailAttribute($value) {
        $this->attributes['email'] = strtolower($value);
    }

    public function setDireccionAttribute($value) {
        $this->attributes['direccion'] = strtolower($value);
    }

    //Scope
   public function scopeTodos($query, $search){
        if ($search) {
              return $query->orWhere('cedula', 'LIKE', "%{$search}%")
                            ->orWhere('nombre', 'LIKE', "%{$search}%")
                            ->orWhere('apellido', 'LIKE', "%{$search}%");
        }
        return $query;
   }
   
    public function scopeSearch($query, $tipo, $search) {
        if ($search) {
              return $query->orWhere('cedula', 'LIKE', "%{$search}%")->where('tipo', '=', $tipo)
                            ->orWhere('nombre', 'LIKE', "%{$search}%")->where('tipo', '=', $tipo)
                            ->orWhere('apellido', 'LIKE', "%{$search}%")->where('tipo', '=', $tipo);
        }
        return $query->where('tipo', '=', $tipo);
   }


}
