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
            'website'=>$values->website,
            'linkedin'=>$values->linkedin,
            'facebook'=>$values->facebook,
            'twitter'=>$values->twitter,
            'youtube'=>$values->youtube,
            'instagram'=>$values->instagram,
            'telegram'=>$values->telegram,
            'status'=>$values->status,
            'bio'=>$values->bio,
            'image_id'=>$values->image_id,
        ];
        if(! is_null($values->password)){
            $update['password'] = bcrypt($values->password);
        }
        return User::where('id', $userId)->update($update);
    }
}