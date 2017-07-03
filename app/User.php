<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Support\Authorization\AuthorizationUserTrait;
use Laracasts\Presenter\PresentableTrait;
use App\Presenters\UserPresenter;

class User extends Authenticatable
{
    use Notifiable,AuthorizationUserTrait,PresentableTrait;

    protected $presenter = UserPresenter::class;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $dates = ['last_login', 'birthday'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'first_name', 'last_name', 'phone', 'avatar',
        'address', 'country_id', 'birthday', 'last_login', 'confirmation_token', 'status',
        'group_id', 'remember_token'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function socialNetworks()
    {
        return $this->hasOne(UserSocialNetworks::class, 'user_id');
    }
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = trim($value) ?: null;
    }
}
