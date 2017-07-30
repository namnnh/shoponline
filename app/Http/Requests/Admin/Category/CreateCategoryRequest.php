<?php

namespace App\Http\Requests\Admin\Category;

use App\Http\Requests\Request;

class CreateCategoryRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|regex:/^[a-zA-Z0-9\-_\.]+$/|unique:categories,name'
        ];
    }
}