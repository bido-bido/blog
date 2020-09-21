<?php

namespace Bido\Category\Tests\Feature;

use Bido\User\Models\User;
use Bido\Category\Models\Category;
use Bido\RolePermissions\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Bido\RolePermissions\Database\Seeds\RolePermissionTableSeeder;

class CategoryTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

//    public function test_authenticated_user_can_see_categories_panel()
//    {
//        $this->actingAsAdmin();
//
//        $this->get(route('categories.index'))->assertOk();
//    }

    public function test_permitted_user_can_see_categories_panel()
    {
        $this->actingAsAdmin();

        $this->get(route('categories.index'))->assertOk();
    }

    public function test_normal_user_can_not_see_categories_panel()
    {
        $this->actingAsUser();

        $this->get(route('categories.index'))->assertStatus(403);
    }

    public function test_permitted_user_can_create_category()
    {
        $this->withoutExceptionHandling();
        $this->actingAsAdmin();
        $this->createCategory();
        $this->assertEquals(1, Category::all()->count()); // number of record in refresh db == 1
    }

    public function test_permitted_user_can_update_category()
    {
        $newTitle = 'aabb3232';
        $this->actingAsAdmin();
        $this->createCategory();
        $this->assertEquals(1, Category::all()->count());
        $this->patch(route('categories.update', 1), [
            'title' => $newTitle,
            'slug' => $this->faker->word,
        ]);

        $this->assertEquals(1, Category::whereTitle($newTitle)->count());
    }

    public function test_user_can_delete_category()
    {
        $this->actingAsAdmin();
        $this->createCategory();
        $this->assertEquals(1, Category::all()->count());

        $this->delete(route('categories.destroy', 1))->assertOk();
    }

    private function actingAsAdmin()
    {
        $this->actingAs(factory(User::class)->create()); // act as user register and login
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);
    }

    private function actingAsUser()
    {
        $this->actingAs(factory(User::class)->create()); // act as user register and login
        $this->seed(RolePermissionTableSeeder::class);
    }

    private function createCategory(): void
    {
        $this->post(route('categories.store'), [
            'title' => $this->faker->word,
            'slug' => $this->faker->word,
        ]);
    }
}