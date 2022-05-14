<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productRequestUpdate extends FormRequest
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
            'name' => 'required|between:5,20',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => '',
            'image' => 'image'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute is required.',
            'between' => 'The :attribute should be between :min - :max.',
            'integer' => 'The :attribute should be an integer',
            'image' => 'You should only upload an image file.'
        ];
    }
}
