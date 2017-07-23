<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Repositories\Activity\ActivityRepository;
use App\Repositories\Session\SessionRepository;
use App\Repositories\Country\CountryRepository;
use App\Repositories\Role\RoleRepository;
use App\Support\Enum\UserStatus;
use App\Http\Requests\Admin\User\UpdateProfileDetailsRequest;
use App\Http\Requests\Admin\User\UpdateProfileLoginDetailsRequest;
use App\Events\User\UpdatedProfileDetails;
use App\Events\User\ChangedAvatar;
use App\Services\Upload\UserAvatarManager;
use App\User;
use Auth;

class ProfileController extends Controller
{
	protected $theUser;
	private $users;

	public function __construct(UserRepository $users)
	{
		$this->users = $users;
        $this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
		$this->middleware(function ($request, $next) {
            $this->theUser = Auth::user();
            return $next($request);
        });
	}

    public function index(RoleRepository $rolesRepo, CountryRepository $countryRepository)
    {
        $user = $this->theUser;
        $edit = true;
        $roles = $rolesRepo->lists();
        $socials = $user->socialNetworks;
        $countries = $countryRepository->lists()->toArray();
        $socialLogins = $this->users->getUserSocialLogins($this->theUser->id);
        $statuses = UserStatus::lists();

        return view('admin/user/profile',
            compact('user', 'edit', 'roles', 'countries', 'socialLogins', 'socials', 'statuses'));
    }

    public function updateDetails(UpdateProfileDetailsRequest $request)
    {
        $this->users->update($this->theUser->id, $request->except('role', 'status'));

        event(new UpdatedProfileDetails);

        return redirect()->back()
            ->withSuccess(trans('app.profile_updated_successfully'));
    }

    public function updateAvatar(Request $request, UserAvatarManager $avatarManager)
    {
        $this->validate($request, [
            'avatar' => 'image'
        ]);

        if ($name = $avatarManager->uploadAndCropAvatar($this->theUser)) {
            return $this->handleAvatarUpdate($name);
        }

        return redirect()->route('admin.profile')
            ->withErrors(trans('app.avatar_not_changed'));
    }

    public function updateAvatarExternal(Request $request, UserAvatarManager $avatarManager)
    {
        $avatarManager->deleteAvatarIfUploaded($this->theUser);

        return $this->handleAvatarUpdate($request->get('url'));
    }

    public function updateSocialNetworks(Request $request)
    {
        $this->users->updateSocialNetworks($this->theUser->id, $request->get('socials'));

        return redirect()->route('admin.profile')
            ->withSuccess(trans('app.socials_updated'));
    }

    public function updateLoginDetails(UpdateProfileLoginDetailsRequest $request)
    {
        $data = $request->except('role', 'status');

        // If password is not provided, then we will
        // just remove it from $data array and do not change it
        if (trim($data['password']) == '') {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $this->users->update($this->theUser->id, $data);

        return redirect()->route('admin.profile')
            ->withSuccess(trans('app.login_updated'));
    }

    public function activity(ActivityRepository $activitiesRepo, Request $request)
    {
        $perPage = 20;
        $user = $this->theUser;

        $activities = $activitiesRepo->paginateActivitiesForUser(
            $this->theUser->id, $perPage, $request->get('search')
        );

        return view('activity.index', compact('activities', 'user'));
    }

    public function sessions(SessionRepository $sessionRepository)
    {
        $profile = true;
        $user = $this->theUser;
        $sessions = $sessionRepository->getUserSessions($user->id);

        return view('admin.user.sessions', compact('sessions', 'user', 'profile'));
    }

    public function invalidateSession($sessionId, SessionRepository $sessionRepository)
    {
        $sessionRepository->invalidateUserSession(
            $this->theUser->id,
            $sessionId
        );

        return redirect()->route('admin.profile.sessions')
            ->withSuccess(trans('app.session_invalidated'));
    }

    /**
    * ============== Private funtion
    */
    private function handleAvatarUpdate($avatar)
    {
        $this->users->update($this->theUser->id, ['avatar' => $avatar]);

        event(new ChangedAvatar);

        return redirect()->route('admin.profile')
            ->withSuccess(trans('app.avatar_changed'));
    }
}
