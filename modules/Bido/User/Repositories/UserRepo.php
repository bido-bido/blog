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
        return User::findOrFail($id);
    }

    public function paginate()
    {
        return User::paginate();

    }

    public function update($userId, $values)
    {
        $update = [
            'name'=>$values->name,
            'email'=>$values->email,
            'username'=>$values->username,
            'username'=>$values->username,
            'mobile'=>$values->mobile,
            'headline'=>$values->headline,
            'telegram'=>$values->telegram,
            'status'=>$values->status,
            'bio'=>$values->bio,
            'image_id'=>$values->image_id,
        ];
        if(! is_null($values->password)){
            $update['password'] = bcrypt($values->password);
        }
        $user = User::findOrFail($userId);
//        $user->removeRole($user->roles);// can remove one role bu I give a collection then use bellow code sync
        $user->syncRoles([]);
        if($values['role']){
            $user->assignRole($values['role']);
        }

        return User::where('id', $userId)->update($update);
    }
}