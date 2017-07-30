<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\User\EloquentUser;
use App\Repositories\User\UserRepository;
use App\Repositories\Country\CountryRepository;
use App\Repositories\Country\EloquentCountry;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Role\EloquentRole;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Permission\EloquentPermission;
use App\Repositories\Activity\ActivityRepository;
use App\Repositories\Activity\EloquentActivity;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\EloquentCategory;
use App\Repositories\Session\SessionRepository;
use App\Repositories\Session\DbSession;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepository::class, EloquentUser::class);
        $this->app->singleton(ActivityRepository::class, EloquentActivity::class);
        $this->app->singleton(SessionRepository::class, DbSession::class);
        $this->app->singleton(CountryRepository::class, EloquentCountry::class);     
        $this->app->singleton(RoleRepository::class, EloquentRole::class);        
        $this->app->singleton(PermissionRepository::class, EloquentPermission::class);
        $this->app->singleton(CategoryRepository::class, EloquentCategory::class);
    }
}
