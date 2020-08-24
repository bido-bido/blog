<?php
namespace Bido\Category\Providers;

use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__. '/../Routes/category_routes.php');
        $this->loadViewsFrom(__DIR__. '/../Resources/Views', 'Categories');
        $this->loadMigrationsFrom(__DIR__. '/../Database/Migrations');
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