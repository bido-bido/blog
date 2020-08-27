<?php

namespace Bido\RolePermissions\Policies;

use Bido\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePermissionPolicy
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
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS)) return true;
        return null;
    }

    public function create($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS)) return true;
        return null;
    }

    public function edit($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS)) return true;
        return null;
    }

    public function delete($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS)) return true;
        return null;
    }
}
