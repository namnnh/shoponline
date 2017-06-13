<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Validator;
use Auth;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    // private $users;

    public function getLogin(){
        $socialProviders = config('auth.social.providers');

        return view('admin.auth.login', compact('socialProviders'));
    }

    public function postLogin(LoginRequest $request){
         $to = $request->has('to') ? "?to=" . $request->get('to') : '';
         $credentials = $this->getCredentials($request);
         dd(Auth::validate($credentials) );
    }

    protected function getCredentials(Request $request)
    {

        $usernameOrEmail = $request->get($this->loginUsername());

        if ($this->isEmail($usernameOrEmail)) {
            return [
                'email' => $usernameOrEmail,
                'password' => $request->get('password')
            ];
        }

        return $request->only($this->loginUsername(), 'password');
    }

    public function loginUsername()
    {
        return 'username';
    }

    private function isEmail($param)
    {
        return ! Validator::make(
            ['username' => $param],
            ['username' => 'email']
        )->fails();
    }
}
