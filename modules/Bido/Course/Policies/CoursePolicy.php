<?php

namespace Bido\Course\Policies;

use Bido\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Bido\RolePermissions\Models\Permission;

class CoursePolicy
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

    public function manage(User $user) //access to user that login
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES);
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)
              || $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
    }

    public function edit($user , $course)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;

        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id;
    }

    public function delete($user , $course)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
        return null;//if no thing returned return null
    }

    public function changeConfirmationStatus($user)
    {
        if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;

        return null;
    }
}
