<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClaseRequest extends FormRequest
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
            'nombre'            => "required|max:191",
            'descripcion'       => 'required|max:191',
            'hora_entrada'      => "required|compareDate:{$this->get('hora_salida')}|compareHoraInicio:{$this->get('hora_salida')}",
            'hora_salida'       => "required|compareDate:{$this->get('hora_entrada')}|compareHoraSalida:{$this->get('hora_entrada')}",
            'ofrenda'           => 'float',
            'impartida'         => 'boolean',
            'turno_facilitador' => 'required'
        ];
    }

    public function messages(){
        return [
            'ofrenda.float' => 'Asignar un monto correcto mayor a Cero.'
        ];
    }
}
