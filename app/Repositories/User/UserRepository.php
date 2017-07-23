<?php

namespace App\Repositories\User;

use App\User;

interface UserRepository
{
	 /**
     * Paginate registered users.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
	public function paginate($perPage, $search = null, $status = null);

	/**
     * Create new user.
     *
     * @param array $data
     * @return mixed
     */
	public function create(array $data);

	/**
     * Set specified role to specified user.
     *
     * @param $userId
     * @param $roleId
     * @return mixed
     */
	public function setRole($userId, $roleId);

     /**
     * Get all social login records for specified user.
     *
     * @param $userId
     * @return mixed
     */
     public function getUserSocialLogins($userId);

      /**
     * Update user social networks.
     * @param $userId
     * @param array $data
     * @return mixed
     */
     public function updateSocialNetworks($userId, array $data);

     /**
     * Delete user with provided id.
     *
     * @param $id
     * @return mixed
     */
     public function delete($id);

     /**
     * Update user specified by it's id.
     *
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Change role for all users who has role $fromRoleId to $toRoleId.
     *
     * @param $fromRoleId Id of current role.
     * @param $toRoleId Id of new role.
     * @return mixed
     */
    public function switchRolesForUsers($fromRoleId, $toRoleId);

     /**
     * Find user by email.
     *
     * @param $email
     * @return null|User
     */
    public function findByEmail($email);

    /**
    * Find user by Token
    */
    public function findByConfirmationToken($token);

    /**
     * Get all users with provided role.
     *
     * @param $roleName
     * @return mixed
     */
    public function getUsersWithRole($roleName);
}
