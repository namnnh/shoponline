<?php
namespace App\Repositories\Role;

interface  RoleRepository
{
    /**
     * Get all system roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();
    
     /**
     * Find system role by id.
     *
     * @param $id Role Id
     * @return Role|null
     */
    public function find($id);
    
    /**
     * Lists all system roles into $key => $column value pairs.
     *
     * @param string $column
     * @param string $key
     * @return mixed
     */
    public function lists ($column = 'name', $key = 'id');

     /**
     * Get all system roles with number of users for each role.
     *
     * @return mixed
     */
    public function getAllWithUsersCount();

    /**
     * Create new system role.
     *
     * @param array $data
     * @return Role
     */
    public function create(array $data);

    /**
     * Find role by name:
     *
     * @param $name
     * @return mixed
     */
    public function findByName($name);

    /**
     * Update specified role.
     *
     * @param $id Role Id
     * @param array $data
     * @return Role
     */
    public function update($id, array $data);

    /**
     * Update the permissions for given role.
     *
     * @param $roleId
     * @param array $permissions
     * @return mixed
     */
    public function updatePermissions($roleId, array $permissions);
}