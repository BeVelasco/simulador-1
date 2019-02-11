<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Lang;

class CalcularPrecioVentaRequest extends FormRequest
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
            'jExcel' => ['required'],
			'PBBD'   => ['required','numeric','between:1,99']
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
            'jExcel.required' => Lang::get('validacion.pvJExcelRequired'),
            'PBBD.required'   => Lang::get('validacion.pvJPBBDRequired'),
            'PBBD.numeric'    => Lang::get('validacion.pvJPBBDNumeric'),
            'PBBD.between'    => Lang::get('validacion.pvJPBBDBetween'),
        ];
    }
}
