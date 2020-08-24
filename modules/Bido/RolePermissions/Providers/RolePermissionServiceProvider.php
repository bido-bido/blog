<?php

namespace Bido\RolePermissions\Providers;

use Illuminate\Support\ServiceProvider;

class RolePermissionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/role_permissions_routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'RolePermissions');
        $this->loadJsonTranslationsFrom(__DIR__.'/../Resources/Lang');
    }

    public function boot()
    {
        config()->set('sidebar.items.role-permissions', [
            'icon'=>'i-role-permissions',
            'url'=>route('role-permissions.index'),
            'title'=>'نقش های کاربری'
        ]);
    }
}