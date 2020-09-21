<?php
namespace Bido\RolePermissions\Database\Seeds;

use Illuminate\Database\Seeder;
use Bido\RolePermissions\Models\Permission;
use Bido\RolePermissions\Models\Role;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Permission::$permissions as $permission){
            Permission::findOrCreate($permission);
        }

        foreach (Role::$roles as $role=>$permissions){
            Role::findOrCreate($role)->givePermissionTo($permissions);
        }

    }
}
