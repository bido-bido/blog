<?php

namespace Bido\RolePermissions\Http\Controllers;

use App\Http\Controllers\Controller;
use Bido\RolePermissions\Models\Role;
use Bido\Common\Responses\AjaxResponses;
use Bido\RolePermissions\Repositories\RoleRepo;
use Bido\RolePermissions\Http\Requests\RoleRequest;
use Bido\RolePermissions\Repositories\PermissionRepo;
use Bido\RolePermissions\Http\Requests\RoleUpdateRequest;

class RolePermissionsController extends Controller
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
        $this->authorize('index', Role::class);
        $roles = $this->roleRepo->all();
        $permissions = $this->permissionRepo->all();

        return view('RolePermissions::index', compact('roles', 'permissions'));
    }

    public function store(RoleRequest $request)
    {
        $this->authorize('create', Role::class);
        $this->roleRepo->create($request);

        return redirect(route('role-permissions.index'));
    }

    public function edit($roleId)
    {
        $this->authorize('edit', Role::class);
        $role = $this->roleRepo->findById($roleId);
        $permissions = $this->permissionRepo->all();

        return view('RolePermissions::edit', compact('role', 'permissions'));
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        $this->authorize('edit', Role::class);
       $this->roleRepo->update($request, $id);

       return redirect(route('role-permissions.index'));

    }

    public function destroy($roleId)
    {
        $this->authorize('delete', Role::class);
        $this->roleRepo->delete($roleId);
        return AjaxResponses::successResponse();
    }
}