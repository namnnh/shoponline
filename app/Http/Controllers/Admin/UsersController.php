<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Controllers\Controller;
use App\Support\Enum\UserStatus;
use App\Repositories\User\UserRepository;
use App\Repositories\Country\CountryRepository;
use App\Repositories\Role\RoleRepository;


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

	public function create(CountryRepository $countryRepository, RoleRepository $roleRepository){
		$countries = $this->parseCountries($countryRepository);
		$roles = $roleRepository->lists()->toArray();
		$statuses = UserStatus::lists();
		  return view('admin.user.add', compact('countries', 'roles', 'statuses'));
	}

	public function store(CreateUserRequest $request){
		$data = $request->all() + ['status' => UserStatus::ACTIVE];
		if (trim($data['username']) == '') {
            $data['username'] = null;
        }

		
		$user = $this->users->create($data);
		$this->users->setRole($user->id, $request->get('role'));
		return redirect()->route('admin.user.list')
            ->withSuccess(trans('app.user_created'));
	}

	/**
	* Private function
	*/
	private function parseCountries(CountryRepository $countryRepository){
		return [0 => 'Select a Country'] + $countryRepository->lists()->toArray();
	}
}
