<?php
namespace App\Repositories\User;

use App\User;
use App\Role;
use DB;
use App\Services\Upload\UserAvatarManager;
use App\Repositories\Role\RoleRepository;

class EloquentUser implements UserRepository
{
    private $avatarManager;
    private $roles;

    public function __construct(UserAvatarManager $avatarManager, RoleRepository $roles)
    {
        $this->avatarManager = $avatarManager;
        $this->roles = $roles;
    }

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

    public function updateSocialNetworks($userId, array $data)
    {
        return $this->find($userId)->socialNetworks()->updateOrCreate([], $data);
    }

    public function delete($id)
    {
        $user = $this->find($id);
        $this->avatarManager->deleteAvatarIfUploaded($user);

        return $user->delete();
    }
    
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function update($id, array $data)
    {
        if (! array_get($data, 'country_id')) {
            $data['country_id'] = null;
        }

        return $this->find($id)->update($data);
    }

    public function switchRolesForUsers($fromRoleId, $toRoleId)
    {
        return DB::table('role_user')
            ->where('role_id', $fromRoleId)
            ->update(['role_id' => $toRoleId]);
    }

    public function findByConfirmationToken($token)
    {
        return User::where('confirmation_token', $token)->first();
    }

    public function getUsersWithRole($roleName)
    {
        return Role::where('name', $roleName)
            ->first()
            ->users;
    }
}