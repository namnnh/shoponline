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
}
