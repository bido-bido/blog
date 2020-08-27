<?php
namespace Bido\Course\Providers;


use Bido\Course\Models\Course;
use Illuminate\Support\Facades\Gate;
use Bido\Course\Policies\CoursePolicy;
use Illuminate\Support\ServiceProvider;
use Bido\RolePermissions\Models\Permission;
use Bido\Course\Database\Seeds\RolePermissionTableSeeder;

class CourseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/courses_routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'Courses');
        $this->loadJsonTranslationsFrom(__DIR__.'/../Resources/Lang');
        \DatabaseSeeder::$seeders[] = RolePermissionTableSeeder::class;
        Gate::policy(Course::class, CoursePolicy::class);

    }

    public function boot()
    {
        config()->set('sidebar.items.courses', [
            'icon'=>'i-courses',
            'url'=>route('courses.index'),
            'title'=>'دوره ها'
        ]);
    }
}