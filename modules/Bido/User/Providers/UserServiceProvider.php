<?php

namespace Bido\User\Providers;

use Bido\User\Models\User;
use Bido\User\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Bido\User\Http\Middleware\StoreUserIp;
use Illuminate\Support\ServiceProvider;
use Bido\User\Database\Seeds\UserTableSeeder;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/user_routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadFactoriesFrom(__DIR__ . '/../Database/Factories');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'User');
        $this->loadJsonTranslationsFrom(__DIR__.'/../Resources/Lang');

        config()->set('auth.providers.users.model',User::class );
        \DatabaseSeeder::$seeders[] = UserTableSeeder::class;
        Gate::policy(User::class, UserPolicy::class);
        $this->app['router']->pushMiddlewareToGroup('web', StoreUserIp::class);
    }

    public function boot()
    {
        config()->set('sidebar.items.users', [
            'icon'=>'i-users',
            'url'=>route('users.index'),
            'title'=>'کاربران'
        ]);
    }
}