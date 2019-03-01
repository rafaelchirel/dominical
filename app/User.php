<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 
        'apellido', 
        'email', 
        'pregunta', 
        'respuesta', 
        'rol', 
        'habilitado',
        'password'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       'remember_token',
    ];

    //Scope
    public function scopeSearch($query, $search, $filter) {
        if ($filter == 'A' || $filter == 'M' && $search != '') {
              return $query->orWhere('nombre', 'LIKE', "%{$search}%")->where('rol', '=', ($filter == 'A') ? true : false)->where('deleted_at', '=', null)
                            ->orWhere('apellido', 'LIKE', "%{$search}%")->where('rol', '=', ($filter == 'A') ? true : false)->where('deleted_at', '=', null);
        }
        else if ($filter == 'A' || $filter == 'M' && $search == '') {
             return $query->where('rol', '=', ($filter == 'A') ? true : false)->where('deleted_at', '=', null);
        }
        else if($filter == 'T' && $search != '') {
            return $query->orWhere('nombre', 'LIKE', "%{$search}%")->where('deleted_at', '=', null)
                        ->orWhere('apellido', 'LIKE', "%{$search}%")->where('deleted_at', '=', null);
        }
        else if($filter == 'T' && $search == '') {
            return $query->where('deleted_at', '=', null);
        }
   }

}
