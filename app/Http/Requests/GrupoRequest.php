<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupoRequest extends FormRequest
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
            'nombre'      => "required|max:100|unique:grupos,nombre,{$this->get('id')},id,deleted_at,NULL",
            'descripcion' => 'required|max:191',
            'edad_ini'    => "required|integer|min:0|max:100|compareAgeIniFin:{$this->get('edad_fin')}",
            'edad_fin'    => "required|integer|min:0|max:100|compareAgeFinIni:{$this->get('edad_ini')}"
        ];
    }

    public function messages(){
        return [
            'edad_ini.required' => 'Campo Edad Inicial es Requerido.',
            'edad_fin.required' => 'Campo Edad Final es Requerido.',
            'edad_ini.max' => 'Edad Inicial debe ser menor a 100',
            'edad_fin.max' => 'Edad Final debe ser menor a 100'
        ];
    }
}
