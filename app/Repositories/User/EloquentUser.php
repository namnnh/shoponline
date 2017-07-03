<?php
namespace App\Repositories\User;

use App\User;
use DB;

class EloquentUser implements UserRepository
{
	public function paginate($perPage, $search = null, $status = null)
    {
        $query = User::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('username', "like", "%{$search}%");
                $q->orWhere('email', 'like', "%{$search}%");
                $q->orWhere('first_name', 'like', "%{$search}%");
                $q->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $result = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }

        return $result;
    }

    public function create(array $data)
    {
        if (! array_get($data, 'country_id')) {
            $data['country_id'] = null;
        }
        return User::create($data);
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function setRole($userId, $roleId)
    {
        $roleId = is_array($roleId) ?: [$roleId];
        return $this->find($userId)->roles()->sync($roleId);
    }

    public function getUserSocialLogins($userId)
    {
        return DB::table('social_logins')
            ->where('user_id', $userId)
            ->get();
    }
}