<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Repositories\Activity\ActivityRepository;
use App\User;

class ProfileController extends Controller
{
	protected $theUser;
	private $users;

	public function __construct(UserRepository $users)
	{
		$this->users = $users;
		$this->middleware(function ($request, $next) {
            $this->theUser = Auth::user();
            return $next($request);
        });
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
}
