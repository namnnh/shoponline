<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Activity\ActivityRepository;


use App\User;

class ActivityController extends Controller
{
    private $activities;

    public function __construct(ActivityRepository $activities)
    {
        $this->middleware('auth');
        $this->middleware('permission:users.activity');
        $this->activities = $activities;
    }

    public function index(Request $request)
    {
        $perPage = 20;
        $adminView = true;

        $activities = $this->activities->paginateActivities($perPage, $request->get('search'));

        return view('admin.activity.index', compact('activities', 'adminView'));
    }

    public function userActivity(User $user, Request $request)
    {
        $perPage = 20;
        $adminView = true;

        $activities = $this->activities->paginateActivitiesForUser(
            $user->id, $perPage, $request->get('search')
        );

        return view('admin.activity.index', compact('activities', 'user', 'adminView'));
    }
}
