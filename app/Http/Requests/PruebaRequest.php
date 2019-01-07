<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest, Auth;

class PruebaRequest extends FormRequest
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
            'entrance_id'         => 'required',
            'user_id'             => 'exists:users,id|nullable',
            'floor'               => ['required', 'numeric'],
            'apt_number'          => ['required', 'numeric'],
            'percent_ideal_parts' => 'required|numeric',
            'starting_balance'    => 'required|numeric',
            'animals'             => 'max:200',
            'other_information'   => 'max:2048',
        ];
    }
}
