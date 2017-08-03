<?php

namespace App\Http\Requests\Admin\Option;

use App\Http\Requests\Request;

class UpdateOptionRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $option = $this->route('option');
        return [
            'name' => 'required|regex:/^[\w\s]+$/|unique:option,name,' . $option->id
        ];
     }
}
    