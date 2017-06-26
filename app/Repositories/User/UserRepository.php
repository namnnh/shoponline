<?php

namespace App\Repositories\User;

use App\User;

interface UserRepository
{
	public function paginate($perPage, $search = null, $status = null);
}
