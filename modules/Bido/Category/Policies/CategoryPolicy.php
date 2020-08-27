<?php

namespace Bido\Category\Policies;

use Bido\User\Models\User;
use Bido\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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

    public function manage(User $user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);
    }
}