<?php
namespace App\Repositories\Role;

interface  RoleRepository
{
    public function lists ($column = 'name', $key = 'id');
}