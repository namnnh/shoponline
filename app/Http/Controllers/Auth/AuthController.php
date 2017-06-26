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
         $throttles = settings('throttle_enabled');
         $to = $request->has('to') ? "?to=" . $request->get('to') : '';
         $credentials = $this->getCredentials($request);
         if (! Auth::validate($credentials)) {
            return redirect()->to('admin/login' . $to)
                ->withErrors(trans('auth.failed'));
         }
         $user = Auth::getProvider()->retrieveByCredentials($credentials);
         Auth::login($user, settings('remember_me') && $request->get('remember'));
         return $this->handleUserWasAuthenticated($request, $throttles, $user);
    }

    protected function handleUserWasAuthenticated(Request $request, $throttles, $user)
    {
        if ($request->has('to')) {
            return redirect()->to($request->get('to'));
        }

        return redirect()->intended();
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
