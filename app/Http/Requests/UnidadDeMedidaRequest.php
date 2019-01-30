<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Lang;

class UnidadDeMedidaRequest extends FormRequest
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
            'descripcion' => [
                'required',
                'max:30',
                'unique:catums,idesc',
                'regex:/^[a-zA-Z\s]+$/u'
            ],
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
            'descripcion.unique'   => Lang::get('validacion.umUnique'),
            'descripcion.required' => Lang::get('validacion.umRequired'),
            'descripcion.max'      => Lang::get('validacion.umMax'),
            'descripcion.regex'    => Lang::get('validacion.umRegex'),
        ];
    }

    /**
     * Get the attributes names that apply to the request
     *
     * @return void
     */
    public function attributes()
    {
        return [
            'descripcion' => Lang::get('validacion.umDescripcion'),
        ];
    }
}