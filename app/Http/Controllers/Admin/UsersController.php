<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\Enum\UserStatus;
use App\Repositories\User\UserRepository;

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
    	$users = $this->users->paginate($perPage);
    	return view('admin.user.list',compact('statuses','users'));
    }
}
