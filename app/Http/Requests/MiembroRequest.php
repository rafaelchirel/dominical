<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MiembroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cedula'      => "required|max:13|cedula|unique:miembros,cedula,{$this->get('id')},id,deleted_at,NULL",
            'nombre'      => 'required|max:100',
            'apellido'    => 'required|max:100',
            'genero'      => 'required|in:F,M',
            'fecha_nac'   => 'required|date_format:Y-m-d',
            'email'       => "nullable|email|max:191|unique:miembros,email,{$this->get('id')},id,deleted_at,NULL",
            'telefono'    => 'required|numeric|telefono',
            'direccion'   => 'required|max:191',
            'tipo'        => 'required|in:F,P,FP',
            'condicion'   => 'required|in:invitado,activo,inactivo',
            'descripcion' => 'max:191'
        ];
    }
    public function messages(){
        return [
            //'telefono.numeric'    => 'Solo numeros'
        ];
    }
}
