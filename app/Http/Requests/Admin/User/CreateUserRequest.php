<?php
namespace App\Http\Requests\Admin\User;

use App\Http\Requests\Request;
use App\User;

class CreateUserRequest extends Request
{
    public function rules()
    {
        return[
            'email' => 'required|email|unique:users,email',
            'username' => 'unique:users,username',
            'password' => 'required|min:6|confirmed',
            'birthday' => 'date',
            'role' => 'required|exists:roles,id'
        ];
    }
}