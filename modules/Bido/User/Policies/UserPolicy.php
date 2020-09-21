<?php

namespace Bido\User\Policies;

use Bido\User\Models\User;
use Bido\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index($user)
    {

        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;

        return null;
    }

    public function addRole($user)
    {

        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;

        return null;
    }

    public function manualVerify($user)
    {

        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;

        return null;
    }

    public function edit($user)
    {

        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;

        return null;
    }

    public function removeRole($user)
    {

        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;

        return null;
    }

}
