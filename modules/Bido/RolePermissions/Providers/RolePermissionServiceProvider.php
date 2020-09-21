<?php

namespace Bido\RolePermissions\Providers;

use Illuminate\Support\Facades\Gate;
use Bido\RolePermissions\Models\Role;
use Illuminate\Support\ServiceProvider;
use Bido\RolePermissions\Models\Permission;
use Bido\RolePermissions\Policies\RolePermissionPolicy;
use Bido\RolePermissions\Database\Seeds\RolePermissionTableSeeder;

class RolePermissionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/role_permissions_routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'RolePermissions');
        $this->loadJsonTranslationsFrom(__DIR__.'/../Resources/Lang');
        \DatabaseSeeder::$seeders[] = RolePermissionTableSeeder::class;

        Gate::policy(Role::class, RolePermissionPolicy::class);
        Gate::before(function ($user){
            return $user->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN) ? true : null;
        });
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