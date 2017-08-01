<?php

namespace App\Http\Requests\Admin\Option;

use App\Http\Requests\Request;

class CreateOptionRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|regex:/^[\w\s]+$/|unique:option,name',
            'option_value' => 'required'
        ]; 
        return $rules;
    }

    public function messages()
    {
        return [
            'option_value.required' => trans('app.the_option_values_is_required')
        ];
    }
}