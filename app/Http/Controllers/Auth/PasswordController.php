<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Events\User\RequestedPasswordResetEmail;
use App\Http\Requests\Auth\PasswordRemindRequest;
use App\Events\User\ResetedPasswordViaEmail;
use App\Repositories\User\UserRepository;
use App\Notifications\ResetPassword;
use App\Http\Requests\Auth\PasswordResetRequest;
use Password;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function forgotPassword()
    {
        return view('admin.auth.password.remind');
    }

    public function sendPasswordReminder(PasswordRemindRequest $request, UserRepository $users)
    {
        $user = $users->findByEmail($request->email);

        $token = Password::getRepository()->create($user);

        $user->notify(new ResetPassword($token));

        event(new RequestedPasswordResetEmail($user));

        return redirect()->to('admin/password/remind')
            ->with('success', trans('app.password_reset_email_sent'));
    }

    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return view('admin.auth.password.reset')->with('token', $token);
    }

    public function postReset(PasswordResetRequest $request)
    {
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect('admin/login')->with('success', trans($response));

            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }

    /**
    * ========= PROTECTED=====================
    */
    protected function resetPassword($user, $password)
    {
        $user->password = $password;
        $user->save();

        event(new ResetedPasswordViaEmail($user));
    }
}