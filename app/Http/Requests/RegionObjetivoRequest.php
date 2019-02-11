<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Lang;

class RegionObjetivoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (! Auth::check())
        {
            return false;
        }
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
            'estado'         => ['required'],
            'personas'       => ['required','numeric','min:1'],
            'ciudadObjetivo' => ['required'],
            'porcentaje'     => ['required','numeric','between:1,100'],
        ];
    }

    /**
     * Get the validation messages that apply to the request
     *
     * @return array
     */
    public function messages()
    {
        return [
            'estado.required'         => Lang::get('validacion.roEstadoRequired'),
            'personas.required'       => Lang::get('validacion.roPersonasRequired'),
            'personas.min'            => Lang::get('validacion.roPersonasMin'),
            'personas.numeric'        => Lang::get('validacion.roPersonasNumeric'),
            'ciudadObjetivo.required' => Lang::get('validacion.roCiuObjRequired'),
            'porcentaje.numeric'      => Lang::get('validacion.roPorcNumeric'),
            'porcentaje.between'      => Lang::get('validacion.roPorcBetween'),
        ];
    }
}