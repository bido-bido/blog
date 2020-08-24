<?php

namespace Bido\RolePermissions\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Bido\Category\Responses\AjaxResponses;
use Bido\RolePermissions\Repositories\RoleRepo;
use Bido\RolePermissions\Http\Requests\RoleRequest;
use Bido\RolePermissions\Repositories\PermissionRepo;
use Bido\RolePermissions\Http\Requests\RoleUpdateRequest;

class RolePermissionsController
{
    private $roleRepo;
    private $permissionRepo;

    public function __construct(RoleRepo $roleRepo, PermissionRepo $permissionRepo)
    {
        $this->roleRepo = $roleRepo;
        $this->permissionRepo = $permissionRepo;
    }

    public function index()
    {
        $roles = $this->roleRepo->all();
        $permissions = $this->permissionRepo->all();

        return view('RolePermissions::index', compact('roles', 'permissions'));
    }

    public function store(RoleRequest $request)
    {
       return $this->roleRepo->create($request);
    }

    public function edit($roleId)
    {
        $role = $this->roleRepo->findById($roleId);
        $permissions = $this->permissionRepo->all();

        return view('RolePermissions::edit', compact('role', 'permissions'));
    }

    public function update(RoleUpdateRequest $request, $id)
    {
       $this->roleRepo->update($request, $id);

       return redirect(route('role-permissions.index'));

    }

    public function destroy($roleId)
    {
        $this->roleRepo->delete($roleId);
        return AjaxResponses::successResponse();
    }
}