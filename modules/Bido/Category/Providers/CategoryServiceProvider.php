<?php
namespace Bido\Category\Providers;

use Bido\Category\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Bido\Category\Policies\CategoryPolicy;

class CategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__. '/../Routes/category_routes.php');
        $this->loadViewsFrom(__DIR__. '/../Resources/Views', 'Categories');
        $this->loadMigrationsFrom(__DIR__. '/../Database/Migrations');
        Gate::policy(Category::class, CategoryPolicy::class);
    }

    public function boot()
    {
        config()->set('sidebar.items.categories', [
            'icon'=>'i-categories',
            'url'=>route('categories.index'),
            'title'=>'دسته بندی ها'
        ]);
    }

}