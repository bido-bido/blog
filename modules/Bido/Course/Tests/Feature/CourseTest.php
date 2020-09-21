<?php

namespace Bido\Course\Tests\Feature;

use Bido\User\Models\User;
use Bido\Course\Models\Course;
use Illuminate\Http\UploadedFile;
use Bido\Category\Models\Category;
use Illuminate\Support\Facades\Storage;
use Bido\RolePermissions\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Bido\RolePermissions\Database\Seeds\RolePermissionTableSeeder;

class CourseTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    //permitted user can see courses index

    public function test_permitted_user_can_see_courses_index()
    {
        $this->actingAsAdmin();
        $this->get(route('courses.index'))->assertOk();

        $this->actingAsSuperAdmin();
        $this->get(route('courses.index'))->assertOk();
    }

    public function test_normal_user_can_not_see_courses_index()
    {
        $this->actingAsUser();
        $this->get(route('courses.index'))->assertStatus(403);
    }

    //permitted user can create courses
    public function test_permitted_user_can_create_course()
    {
        $this->actingAsAdmin();
        $this->get(route('courses.create'))->assertOk();

        $this->actingAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('courses.create'))->assertOk();
    }

    public function test_normal_user_can_not_see_create_course()
    {
        $this->actingAsUser();
        $this->get(route('courses.create'))->assertStatus(403);
    }

    public function test_permitted_user_can_store_course()
    {
        $this->actingAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES, Permission::PERMISSION_TEACH);
//        Storage::fake('local'); // if comment it not happen anything
        $response = $this->post(route('courses.store'), $this->courseData());


        $response->assertRedirect(route('courses.index'));
        $this->assertEquals(1, Course::all()->count());
    }

    //permitted user can edit courses

    public function  test_permitted_user_can_edit_course()
    {
        $this->actingAsAdmin();
        $course = $this->createCourse(); // create course for user actingAsAdmin
        $this->get(route('courses.edit', $course->id))->assertOk();

        $this->actingAsUser();
        $course = $this->createCourse(); //create course for user actingAsUser
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES); // giv permission fro actingAsUser
        $this->get(route('courses.edit', $course->id))->assertOk();

    }

    public function  test_permitted_user_can_not_edit_other_users_courses()
    {
        $this->actingAsUser();
        $course = $this->createCourse();

        $this->actingAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('courses.edit', $course->id))->assertStatus(403);

    }

    public function test_normal_user_can_not_edit_course()
    {
        $this->actingAsUser();
        $course = $this->createCourse();
        $this->get(route('courses.edit', $course->id))->assertStatus(403);

    }

    //permitted user can update courses

    public function test_permitted_user_can_update_course()
    {
        $this->actingAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES, Permission::PERMISSION_TEACH);
        $course = $this->createCourse();

        $this->patch(route('courses.update', $course->id), [
            'title' => 'updated title',
            'slug' => 'updated slug',
            'teacher_id' => auth()->id(),
            'category_id' => $course->category->id,
            "priority" => 12,
            "price" => 1200,
            "percent" => 80,
            'type' => Course::TYPE_CASH,
            'image' => UploadedFile::fake()->image('banner.jpg'),
            'status' => Course::STATUS_COMPLETED,
        ])->assertRedirect(route('courses.index'));

        $course = $course->fresh();
        $this->assertEquals('updated title' , $course->title);
    }

    public function test_normal_user_can_not_update_course()
    {
        $this->actingAsAdmin();
        $course = $this->createCourse();

        $this->actingAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_TEACH);
        $this->patch(route('courses.update', $course->id), [
            'title' => 'updated title',
            'slug' => 'updated slug',
            'teacher_id' => auth()->id(),
            'category_id' => $course->category->id,
            "priority" => 12,
            "price" => 1200,
            "percent" => 80,
            'type' => Course::TYPE_CASH,
            'image' => UploadedFile::fake()->image('banner.jpg'),
            'status' => Course::STATUS_COMPLETED,
        ])->assertStatus(403);

    }

    //permitted user can delete courses

    public function test_normal_user_can_delete_course()
    {
        $this->actingAsAdmin();
        $course = $this->createCourse();

        $this->delete(route('courses.destroy', $course->id))->assertOk();

        $this->assertEquals(0, Course::count());
    }

    public function test_permitted_user_can_not_delete_course()
    {
        $this->actingAsAdmin();
        $course = $this->createCourse();

        $this->actingAsUser();
        $this->delete(route('courses.destroy', $course->id))->assertStatus(403);

        $this->assertEquals(1, Course::count());
    }

    //permitted user can accept courses

    public function test_permitted_user_can_change_confirmation_status_courses()
    {
        $this->actingAsAdmin();
        $course = $this->createCourse();

        $this->patch(route('courses.accept', $course->id), [])->assertOk();
        $this->patch(route('courses.reject', $course->id), [])->assertOk();
        $this->patch(route('courses.lock', $course->id), [])->assertOk();
    }

    public function test_normal_user_can_not_change_confirmation_status_courses()
    {
        $this->actingAsAdmin();
        $course = $this->createCourse();

        $this->actingAsUser();
        $this->patch(route('courses.accept', $course->id), [])->assertStatus(403);
        $this->patch(route('courses.reject', $course->id), [])->assertStatus(403);
        $this->patch(route('courses.lock', $course->id), [])->assertStatus(403);
    }

    private function actingAsAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_COURSES);
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

    private function createCourse()
    {
        $data = $this->courseData() + ['confirmation_status' => Course::CONFIRMATION_STATUS_PENDING,];
        unset($data['image']);
        return Course::create($data);
    }

    private function createCategory()
    {
        return Category::create(['title' => $this->faker->word, "slug" => $this->faker->word]);
    }

    /**
     * @param $category
     *
     * @return array
     */
    private function courseData(): array
    {
        $category = $this->createCategory();
        return [
            'title' => $this->faker->sentence(2),
            'slug' => $this->faker->sentence(2),
            'teacher_id' => auth()->id(),
            'category_id' => $category->id,
            "priority" => 12,
            "price" => 1200,
            "percent" => 70,
            'type' => Course::TYPE_FREE,
            'image' => UploadedFile::fake()->image('banner.jpg'),
            'status' => Course::STATUS_COMPLETED,
        ];
}
}
