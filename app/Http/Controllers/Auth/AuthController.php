<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\User\UserRepository;
use App\Repositories\Role\RoleRepository;
use App\Events\User\LoggedOut;
use App\Events\User\Registered;
use Validator;
use App\Mailers\UserMailer;
use App\Support\Enum\UserStatus;
use Auth;
use Illuminate\Cache\RateLimiter;

class AuthController extends Controller
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->middleware('guest', ['except' => ['getLogout']]);
        $this->middleware('auth', ['only' => ['getLogout']]);
        $this->middleware('registration', ['only' => ['getRegister', 'postRegister']]);
        $this->users = $users;
    }
    /**
     * @var UserRepository
     */

    public function getLogin(){
        $socialProviders = config('auth.social.providers');
        return view('admin.auth.login', compact('socialProviders'));
    }

    public function getRegister()
    {
        $socialProviders = config('auth.social.providers');

        return view('admin.auth.register', compact('socialProviders'));
    }

    public function postRegister(RegisterRequest $request, UserMailer $mailer, RoleRepository $roles)
    {
        // Determine user status. User's status will be set to UNCONFIRMED
        // if he has to confirm his email or to ACTIVE if email confirmation is not required
        $status = settings('reg_email_confirmation')
            ? UserStatus::UNCONFIRMED
            : UserStatus::ACTIVE;

        // Add the user to database
        $user = $this->users->create(array_merge(
            $request->only('email', 'username', 'password'),
            ['status' => $status]
        ));

        $this->users->updateSocialNetworks($user->id, []);

        $role = $roles->findByName('User');
        $this->users->setRole($user->id, $role->id);

        // Check if email confirmation is required,
        // and if it does, send confirmation email to the user.
        if (settings('reg_email_confirmation')) {
            $this->sendConfirmationEmail($mailer, $user);
            $message = trans('app.account_create_confirm_email');
        } else {
            $message = trans('app.account_created_login');
        }

        event(new Registered($user));

        return redirect('/admin/login')->with('success', $message);
    }

    public function confirmEmail($token)
    {
        if ($user = $this->users->findByConfirmationToken($token)) {
            $this->users->update($user->id, [
                'status' => UserStatus::ACTIVE,
                'confirmation_token' => null
            ]);

            return redirect()->to('/admin/login')
                ->withSuccess(trans('app.email_confirmed_can_login'));
        }

        return redirect()->to('/admin/login')
            ->withErrors(trans('app.wrong_confirmation_token'));
    }

    public function postLogin(LoginRequest $request){
        // In case that request throttling is enabled, we have to check if user can perform this request.
         $throttles = settings('throttle_enabled');

         $to = $request->has('to') ? "?to=" . $request->get('to') : '';

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

         $credentials = $this->getCredentials($request);
         if (! Auth::validate($credentials)) {
             if ($throttles) {
                $this->incrementLoginAttempts($request);
            }

            return redirect()->to('admin/login' . $to)
                ->withErrors(trans('auth.failed'));
         }
         $user = Auth::getProvider()->retrieveByCredentials($credentials);

         if ($user->isUnconfirmed()) {
            return redirect()->to('login' . $to)
                ->withErrors(trans('app.please_confirm_your_email_first'));
        }

        if ($user->isBanned()) {
            return redirect()->to('login' . $to)
                ->withErrors(trans('app.your_account_is_banned'));
        }

         Auth::login($user, settings('remember_me') && $request->get('remember'));
         return $this->handleUserWasAuthenticated($request, $throttles, $user);
    }

    public function getLogout()
    {
        event(new LoggedOut());

        Auth::logout();

        return redirect('admin/login');
    }

    public function loginUsername()
    {
        return 'username';
    }


    /**
    *========= PRIVATE FUNCTION ================
    */
    private function isEmail($param)
    {
        return ! Validator::make(
            ['username' => $param],
            ['username' => 'email']
        )->fails();
    }

    private function sendConfirmationEmail(UserMailer $mailer, $user)
    {
        $token = str_random(60);
        $this->users->update($user->id, ['confirmation_token' => $token]);
        $mailer->sendConfirmationEmail($user, $token);
    }

    /**
    *========== PROTECTED FUNCTION =============
    */

    protected function maxLoginAttempts()
    {
        return settings('throttle_attempts', 5);
    }

    protected function lockoutTime()
    {
        $lockout = (int) settings('throttle_lockout_time');

        if ($lockout <= 1) {
            $lockout = 1;
        }

        return 60 * $lockout;
    }

    protected function incrementLoginAttempts(Request $request)
    {
        app(RateLimiter::class)->hit(
            $request->input($this->loginUsername()).$request->ip()
        );
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

    protected function hasTooManyLoginAttempts(Request $request)
    {
        return app(RateLimiter::class)->tooManyAttempts(
            $request->input($this->loginUsername()).$request->ip(),
            $this->maxLoginAttempts(), $this->lockoutTime() / 60
        );
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = app(RateLimiter::class)->availableIn(
            $request->input($this->loginUsername()).$request->ip()
        );

        return redirect('admin/login')
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getLockoutErrorMessage($seconds),
            ]);
    }

    protected function getLockoutErrorMessage($seconds)
    {
        return trans('auth.throttle', ['seconds' => $seconds]);
    }

     /**
     * Determine how many retries are left for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    protected function retriesLeft(Request $request)
    {
        $attempts = app(RateLimiter::class)->attempts(
            $request->input($this->loginUsername()).$request->ip()
        );

        return $this->maxLoginAttempts() - $attempts + 1;
    }
}
