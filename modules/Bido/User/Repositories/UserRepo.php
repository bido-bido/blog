<?php

namespace Bido\User\Repositories;

use Bido\User\Models\User;

class UserRepo
{
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }
}