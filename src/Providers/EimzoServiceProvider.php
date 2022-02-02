<?php

namespace Asadbek\Eimzo\Providers;

use Illuminate\Support\ServiceProvider;

class EimzoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'eimzo');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
//        $this->loadViewsFrom(__DIR__.'/views', 'todolist');
        $this->publishes([
            __DIR__.'/../recoures/views' => base_path('resources/views/asadbek/eimzo'),
            __DIR__.'/../recoures/assets' => base_path('public/assets'),

        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
