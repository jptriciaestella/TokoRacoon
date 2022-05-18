<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class checkoutRequest extends FormRequest
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
            'firstName' => 'required|between:5,20',
            'lastName' => 'required|between:5,20',
            'address' => 'required|between:10,100',
            'country' => 'required',
            'city' => 'required',
            'zip' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute is required.',
            'between' => 'The :attribute should be between :min - :max.',
            'integer' => 'The :attribute should be an integer',
        ];
    }
}
