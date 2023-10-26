<?php

namespace LaravelCoreModule\CoreModuleMaker;

use Illuminate\Support\ServiceProvider;

use Spatie\Activitylog\ActivitylogServiceProvider as ActivitylogProvider;

class ActivityLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
	{
        // Use the register method to customize the behavior of the ActivitylogServiceProvider
        $this->app->register(ActivitylogProvider::class);

        // You can customize the configuration of spatie/laravel-activitylog here
        $this->mergeConfigFrom(
            __DIR__.'/../config/activitylog.php',
            'activitylog'
        );

        // You can also publish configuration files from your package
        $this->publishes([
            __DIR__.'/../config/activitylog.php' => config_path('activitylog.php'),
        ], 'config');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/myactivitylog.php' => config_path('myactivitylog.php'),
        ], 'config');
    }
}
