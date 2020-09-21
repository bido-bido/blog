<?php

namespace Bido\User\Database\Seeds;

use Bido\User\Models\User;
use Illuminate\Database\Seeder;
use Bido\RolePermissions\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::$defaultUsers as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                [
                    'email' => $user['email'],
                    'name' => $user['name'],
                    'password' => bcrypt($user['password']),

                ])->assignRole($user['role']);
        }
    }
}
