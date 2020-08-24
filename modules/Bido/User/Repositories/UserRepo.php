<?php

namespace Bido\User\Repositories;

use Bido\User\Models\User;

class UserRepo
{
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function getTeachers()
    {
        return User::permission('teach')->get();
    }

    public function findById($id)
    {
        return User::find($id);
    }
}