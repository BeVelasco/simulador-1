<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Lang;

class ProductoNuevoRequest extends FormRequest
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
            'descripcion'  => ['required','max:100','regex:/^[a-zA-Z\sñÑ]+$/u'],
            'unidadMedida' => ['required','numeric','exists:catums,id'],
            'porcion'      => ['required','numeric','regex:/(?!^0*$)(?!^0*\.0*$)^\d{1,6}(\.\d{1,2})?$/u']
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
            'descripcion.required'  => Lang::get('validacion.desProdUnique'),
            'descripcion.max'       => Lang::get('validacion.descProdMax'),
            'descripcion.regex'     => Lang::get('validacion.descProdRegex'),
            'unidadMedida.required' => Lang::get('validacion.umProdRequired'),
            'unidadMedida.numeric'  => Lang::get('validacion.umProdNumeric'),
            'unidadMedida.exists'   => Lang::Get('validacion.umProdExists'),
            'porcion.required'      => Lang::get('validacion.porcProdRequired'),
            'porcion.numeric'       => Lang::get('validacion.porcProdNumeric'),
            'porcion.regex'         => Lang::get('validacion.porcProdRegex'),
        ];
    }
}
