<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Permission\PermissionRepository;
use App\Events\Role\PermissionsUpdated;
use App\Http\Requests\Admin\Permission\CreatePermissionRequest;
use App\Http\Requests\Admin\Permission\UpdatePermissionRequest;
use App\Permission;

class PermissionsController extends Controller
{
    private $roles;

    private $permissions;

    public function __construct(RoleRepository $roles, PermissionRepository $permissions)
    {
        $this->middleware('auth');
        $this->middleware('permission:permissions.manage');
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    public function index()
    {
        $roles = $this->roles->all();
        $permissions = $this->permissions->all();

        return view('admin.permission.index', compact('roles', 'permissions'));
    }

    public function create()
    {
        $edit = false;

        return view('admin.permission.add-edit', compact('edit'));
    }

    public function edit(Permission $permission)
    {
        $edit = true;

        return view('admin.permission.add-edit', compact('edit', 'permission'));
    }
    
    public function store(CreatePermissionRequest $request)
    {
        $this->permissions->create($request->all());

        return redirect()->route('admin.permission.index')
            ->withSuccess(trans('app.permission_created_successfully'));
    }

    public function destroy(Permission $permission)
    {
        if (! $permission->removable) {
            throw new NotFoundHttpException;
        }

        $this->permissions->delete($permission->id);

        return redirect()->route('admin.permission.index')
            ->withSuccess(trans('app.permission_deleted_successfully'));
    }

    public function update(Permission $permission, UpdatePermissionRequest $request)
    {
        $this->permissions->update($permission->id, $request->all());

        return redirect()->route('admin.permission.index')
            ->withSuccess(trans('app.permission_updated_successfully'));
    }

    public function saveRolePermissions(Request $request)
    {
        $roles = $request->get('roles');

        $allRoles = $this->roles->lists('id');

        foreach ($allRoles as $roleId) {
            $permissions = array_get($roles, $roleId, []);
            $this->roles->updatePermissions($roleId, $permissions);
        }

        event(new PermissionsUpdated);

        return redirect()->route('admin.permission.index')
            ->withSuccess(trans('app.permissions_saved_successfully'));
    }
}
