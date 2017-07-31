<?php

namespace App\Http\Requests\Admin\Category;

use App\Http\Requests\Request;

class UpdateCategoryRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $category = $this->route('category');
        return [
            'name' => 'required|regex:/^[\w\s]+$/|unique:roles,name,' . $category->id
        ];
     }
}
    