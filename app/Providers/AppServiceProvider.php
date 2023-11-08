<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Eloquent\EloquentRoleRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, function () {

            $repository = new EloquentUserRepository(new User());

            return $repository;
        });

        $this->app->bind(RoleRepository::class, function () {

            $repository = new EloquentRoleRepository(new Role());

            return $repository;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
