<?php

namespace Bido\Media\Providers;

use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    public function boot()
    {

    }
}