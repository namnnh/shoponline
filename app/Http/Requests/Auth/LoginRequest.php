<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class LoginRequest extends Request
{
    public function rules()
    {
         return [
            'username' => 'required',
            'password' => 'required'
        ];
    }
}