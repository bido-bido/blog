<?php

namespace Bido\RolePermissions\Repositories;

use Spatie\Permission\Models\Role;

class RoleRepo
{
    public function all()
    {
        return Role::all();
    }

    public function create($request)
    {
        return Role::create(['name' => $request->name])->syncPermissions($request->permissions);
    }

    public function findById($roleId)
    {
        return Role::findOrFail($roleId);
    }

    public function update($request, $id)
    {
        $role = $this->findById($id);
        return $role->syncPermissions($request->permissions)->update(['name' => $request->name]);
    }

    public function delete($roleId)
    {
        return Role::where('id', $roleId)->delete();
    }
}