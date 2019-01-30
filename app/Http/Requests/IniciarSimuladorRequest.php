<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Lang;

class IniciarSimuladorRequest extends FormRequest
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
        return ['iP'=>['required','exists:productos,id']];
    }

    /**
     * Get the validation messages that apply to the request
     *
     * @return array
     */
    public function messages()
    {
        return [
            'iP.required' => Lang::get('validacion.iniSimIpRequired'),
            'iP.exists'   => Lang::get('validacion.iniSimIpExists'),
        ];
    }
}
