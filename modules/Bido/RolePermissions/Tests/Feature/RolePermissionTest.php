<?php

namespace Bido\RolePermissions\Tests\Feature;

use Tests\TestCase;
use Bido\User\Models\User;
use Bido\RolePermissions\Models\Role;
use Bido\RolePermissions\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Bido\RolePermissions\Database\Seeds\RolePermissionTableSeeder;

class RolePermissionTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_permitted_user_can_see_index()
    {
        $this->actingAsAdmin();
        $this->get(route('role-permissions.index'))->assertOk();
    }

    public function test_normal_user_can_not_see_index()
    {
        $this->actingAsUser();
        $this->get(route('role-permissions.index'))->assertStatus(403);
    }

    public function test_permitted_user_can_store_roles()
    {
        $this->actingAsAdmin();
        $this->post(route('role-permissions.store'), [
            'name' => 'tessst',
            'permissions' => [
                Permission::PERMISSION_MANAGE_COURSES,
                Permission::PERMISSION_MANAGE_CATEGORIES,
            ],
        ])->assertRedirect(route('role-permissions.index'));

        $this->assertEquals(count(Role::$roles) + 1, Role::count());
    }

    public function test_normal_user_can_not_store_roles()
    {
        $this->actingAsUser();
        $this->post(route('role-permissions.store'), [
            'name' => 'tessst',
            'permissions' => [
                Permission::PERMISSION_MANAGE_COURSES,
                Permission::PERMISSION_MANAGE_CATEGORIES,
            ],
        ])->assertStatus(403);

        $this->assertEquals(count(Role::$roles), Role::count());
    }

    public function test_permitted_user_can_see_edit()
    {
        $this->actingAsAdmin();
        $role = $this->createRole();
        $this->get(route('role-permissions.edit', $role->id))->assertOk();
    }

    public function test_normal_user_can_not_see_edit()
    {
        $this->actingAsUser();
        $role = $this->createRole();
        $this->get(route('role-permissions.edit', $role->id))->assertStatus(403);
    }

    public function test_permitted_user_can_update_roles()
    {
        $this->actingAsAdmin();
        $role = $this->createRole();
        $this->patch(route('role-permissions.update', $role->id), [
            'id'=>$role->id,
            'name'=>'tesst',
            'permissions' => [
                Permission::PERMISSION_TEACH
            ],
        ])->assertRedirect(route('role-permissions.index'));

        $this->assertEquals('tesst', $role->fresh()->name);
    }

    public function test_normal_user_can_not_update_roles()
    {
        $this->actingAsUser();
        $role = $this->createRole();
        $this->patch(route('role-permissions.update', $role->id), [
            'id'=>$role->id,
            'name'=>'tesst',
            'permissions' => [
                Permission::PERMISSION_TEACH
            ],
        ])->assertStatus(403);

        $this->assertEquals($role->name, $role->fresh()->name);
    }

    public function test_permitted_user_can_delete_role()
    {
        $this->actingAsAdmin();
        $role = $this->createRole();
        $this->delete(route('role-permissions.destroy', $role->id))->assertOk();
        $this->assertEquals(count(Role::$roles), Role::count());
    }

    public function test_normal_user_can_not_delete_role()
    {
        $this->actingAsUser();
        $role = $this->createRole();
        $this->delete(route('role-permissions.destroy', $role->id))->assertStatus(403);
        $this->assertEquals(count(Role::$roles)+1, Role::count());
    }

    private function actingAsAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS);
    }

    private function actingAsSuperAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_SUPER_ADMIN);
    }

    private function actingAsUser()
    {
        $this->createUser();
    }

    private function createUser(): void
    {
        $this->actingAs(factory(User::class)->create()); // act as user register and login
        $this->seed(RolePermissionTableSeeder::class);
    }

    public function createRole()
    {
        return Role::create(['name' => 'ttteest'])->syncPermissions([
            Permission::PERMISSION_TEACH,
            Permission::PERMISSION_MANAGE_COURSES,
        ]);
    }
}