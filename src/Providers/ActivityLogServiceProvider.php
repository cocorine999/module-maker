<?php

namespace LaravelCoreModule\CoreModuleMaker\Providers;

use Illuminate\Support\ServiceProvider;

class ActivityLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
	{
        // Use the register method to customize the behavior of the ActivitylogServiceProvider
        $this->app->register(\Spatie\Activitylog\ActivitylogServiceProvider::class);

        // You can customize the configuration of spatie/laravel-activitylog here
        $this->mergeConfigFrom(
            dirname(__DIR__, 2) . '/vendor/spatie/laravel-activitylog/config/activitylog.php',
            'activitylog'
        );

        // You can also publish configuration files from your package
        $this->publishes([
            dirname(__DIR__, 2) . '/vendor/spatie/laravel-activitylog/config/activitylog.php' => config_path('activitylog.php'),
        ], 'config');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish the migrations from the spatie/laravel-activitylog package
        if ($this->app->runningInConsole()) {
            $this->publishes([
                 dirname(__DIR__, 2) . '/vendor/spatie/laravel-activitylog/database/migrations' => database_path('migrations'),
            ], 'activitylog-migrations');
        }
        $this->publishes([
             dirname(__DIR__, 2) . '/vendor/spatie/laravel-activitylog/config/myactivitylog.php' => config_path('myactivitylog.php'),
        ], 'config');

        // $this->app['router']->middleware('activitylog', \Spatie\Activitylog\Middlewares\Activitylog::class);

    }
}
