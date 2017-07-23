<?php

namespace App\Http\Controllers\Admin;

use Cache;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Role\CreateRoleRequest;
use App\Http\Requests\Admin\Role\UpdateRoleRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Role;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RolesController extends Controller
{
    private $roles;

    public function __construct(RoleRepository $roles)
    {
        $this->middleware('auth');
        $this->roles = $roles;
        $this->middleware('permission:roles.manage');
    }

    public function index()
    {
        $roles = $this->roles->getAllWithUsersCount();

        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        $edit = false;

        return view('admin.role.add-edit', compact('edit'));
    }

    public function store(CreateRoleRequest $request)
    {
        $this->roles->create($request->all());

        return redirect()->route('admin.role.index')
            ->withSuccess(trans('app.role_created'));
    }

    public function delete(Role $role, UserRepository $userRepository)
    {
        if (! $role->removable) {
            throw new NotFoundHttpException;
        }

        $userRole = $this->roles->findByName('User');

        $userRepository->switchRolesForUsers($role->id, $userRole->id);

        $this->roles->delete($role->id);

        Cache::flush();

        return redirect()->route('admin.role.index')
            ->withSuccess(trans('app.role_deleted'));
    }
    
    public function edit(Role $role)
    {
        $edit = true;
        return view('admin.role.add-edit', compact('edit','role'));
    }

    public function update(Role $role, UpdateRoleRequest $request){
         $this->roles->update($role->id, $request->all());

        return redirect()->route('admin.role.index')
            ->withSuccess(trans('app.role_updated'));
    }
}
