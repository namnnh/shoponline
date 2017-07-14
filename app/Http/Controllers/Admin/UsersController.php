<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Requests\Admin\User\UpdateDetailsRequest;
use App\Http\Requests\Admin\User\UpdateLoginDetailsRequest;
use App\Http\Controllers\Controller;
use App\Support\Enum\UserStatus;
use App\Repositories\User\UserRepository;
use App\Repositories\Country\CountryRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Activity\ActivityRepository;
use App\Repositories\Session\SessionRepository;
use App\Services\Upload\UserAvatarManager;
use Illuminate\Support\Facades\Input;
use App\User;
use Auth;


class UsersController extends Controller
{
	/**
     * @var UserRepository
     */
    private $users;

	public function __construct(UserRepository $users)
	{
		  $this->users = $users;
	}

    public function index()
    {
        $perPage = 20;
    	$statuses = ['' => trans('app.all')] + UserStatus::lists();
    	$users = $this->users->paginate($perPage,Input::get('search'), Input::get('status'));
    	return view('admin.user.list',compact('statuses','users'));
    }

    public function view(User $user, ActivityRepository $activities)
    {
        $socialNetworks = $user->socialNetworks;

        $userActivities = $activities->getLatestActivitiesForUser($user->id, 10);

        return view('admin.user.view', compact('user', 'socialNetworks', 'userActivities'));
    }

	public function create(CountryRepository $countryRepository, RoleRepository $roleRepository)
	{
		$countries = $this->parseCountries($countryRepository);
		$roles = $roleRepository->lists()->toArray();
		$statuses = UserStatus::lists();
		  return view('admin.user.add', compact('countries', 'roles', 'statuses'));
	}

	public function store(CreateUserRequest $request)
	{
		$data = $request->all() + ['status' => UserStatus::ACTIVE];
		if (trim($data['username']) == '') 
		{
            $data['username'] = null;
        }
		$user = $this->users->create($data);
		$this->users->setRole($user->id, $request->get('role'));
		$this->users->updateSocialNetworks($user->id, []);
		return redirect()->route('admin.user.list')
            ->withSuccess(trans('app.user_created'));
	}

	public function delete(User $user)
    {
        if ($user->id == Auth::id()) {
            return redirect()->route('admin.user.list')
                ->withErrors(trans('app.you_cannot_delete_yourself'));
        }

        $this->users->delete($user->id);

        return redirect()->route('admin.user.list')
            ->withSuccess(trans('app.user_deleted'));
    }

	public function edit(User $user,CountryRepository $countryRepository, RoleRepository $roleRepository)
	{
		$edit = true;
		$countries = $this->parseCountries($countryRepository);
		$roles = $roleRepository->lists()->toArray();
		$statuses = UserStatus::lists();
		$socialLogins = $this->users->getUserSocialLogins($user->id);
		$socials = $user->socialNetworks;
		
		return view('admin.user.edit',
            compact('edit', 'user', 'countries', 'roles', 'statuses','socialLogins','socials'));
	}

	public function updateDetails(User $user, UpdateDetailsRequest $request)
	{
		$this->users->update($user->id, $request->all());
		$this->users->setRole($user->id, $request->get('role'));
		return redirect()->back()
            ->withSuccess(trans('app.user_updated'));
	}

	public function updateAvatar(User $user,Request $request,UserAvatarManager $avatarManager)
	{
		$this->validate($request, ['avatar' => 'image']);
		if ($name = $avatarManager->uploadAndCropAvatar($user)) {
			 $this->users->update($user->id, ['avatar' => $name]);
			 return redirect()->route('admin.user.edit', $user->id)
                ->withSuccess(trans('app.avatar_changed'));
		}
		return redirect()->route('admin.user.edit', $user->id)
            ->withErrors(trans('app.avatar_not_changed'));
	}

	public function updateSocialNetworks(User $user, Request $request)
    {
        $this->users->updateSocialNetworks($user->id, $request->get('socials'));

        return redirect()->route('admin.user.edit', $user->id)
            ->withSuccess(trans('app.socials_updated'));
    }

    public function updateLoginDetails(User $user, UpdateLoginDetailsRequest $request)
    {
        $data = $request->all();

        if (trim($data['password']) == '') {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $this->users->update($user->id, $data);

        return redirect()->route('admin.user.edit', $user->id)
            ->withSuccess(trans('app.login_updated'));
    }

    public function sessions(User $user, SessionRepository $sessionRepository)
    {
        $adminView = true;
        $sessions = $sessionRepository->getUserSessions($user->id);

        return view('admin.user.sessions', compact('sessions', 'user', 'adminView'));
    }

    public function invalidateSession(User $user, $sessionId, SessionRepository $sessionRepository){
    	$sessionRepository->invalidateUserSession($user->id, $sessionId);

        return redirect()->route('admin.user.sessions', $user->id)
            ->withSuccess(trans('app.session_invalidated'));
    }
	/**
	* Private function
	*/
	private function parseCountries(CountryRepository $countryRepository){
		return [0 => 'Select a Country'] + $countryRepository->lists()->toArray();
	}
}
