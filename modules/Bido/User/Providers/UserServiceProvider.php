<?php

namespace Bido\User\Providers;

use Bido\User\Models\User;
use Bido\User\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        config()->set('auth.providers.users.model',User::class );
        Gate::policy(User::class, UserPolicy::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/user_routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadFactoriesFrom(__DIR__ . '/../Database/Factories');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'User');


        config()->set('sidebar.items.users', [
            'icon'=>'i-users',
            'url'=>route('users.index'),
            'title'=>'کاربران'
        ]);
    }
}