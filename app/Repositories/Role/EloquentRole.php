<?php
namespace App\Repositories\Role;

use App\Role;

class EloquentRole implements RoleRepository
{
    public function lists ($column = 'name', $key = 'id')
    {
        return Role::orderBy('name')->pluck($column,$key);
    }
}