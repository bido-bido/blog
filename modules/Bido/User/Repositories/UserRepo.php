<?php

namespace Bido\User\Repositories;

use Bido\User\Models\User;
use Bido\RolePermissions\Models\Permission;

class UserRepo
{
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function getTeachers()
    {
        return User::permission(Permission::PERMISSION_TEACH)->get();
    }

    public function findById($id)
    {
        return User::find($id);
    }

    public function paginate()
    {
        return User::paginate();

    }
}