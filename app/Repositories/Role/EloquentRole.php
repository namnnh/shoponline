<?php
namespace App\Repositories\Role;

use App\Role;
use App\Events\Role\Created;
use App\Events\Role\Deleted;
use App\Events\Role\Updated;
use App\Support\Authorization\CacheFlusherTrait;
use DB;

class EloquentRole implements RoleRepository
{
    use CacheFlusherTrait;
    
    public function all()
    {
        return Role::all();
    }
    
    public function find($id)
    {
        return Role::find($id);
    }
    
    public function lists ($column = 'name', $key = 'id')
    {
        return Role::orderBy('name')->pluck($column,$key);
    }

    public function getAllWithUsersCount()
    {
        $prefix = DB::getTablePrefix();

        return Role::leftJoin('role_user', 'roles.id', '=', 'role_user.role_id')
            ->select('roles.*', DB::raw("count({$prefix}role_user.user_id) as users_count"))
            ->groupBy('roles.id')
            ->get();
    }

    public function create(array $data)
    {
        $role = Role::create($data);

        event(new Created($role));

        return $role;
    }

    public function findByName($name)
    {
        return Role::where('name', $name)->first();
    }

    public function delete($id)
    {
        $role = $this->find($id);

        event(new Deleted($role));

        return $role->delete();
    }

    public function update($id, array $data)
    {
        $role = $this->find($id);

        $role->update($data);

        event(new Updated($role));

        return $role;
    }

    public function updatePermissions($roleId, array $permissions)
    {
        $role = $this->find($roleId);

        $role->perms()->sync($permissions);

        $this->flushRolePermissionsCache($role);
    }
}