<?php namespace Microffice\EloquentUnits;

use Illuminate\Support\ServiceProvider;
use Microffice\EloquentUnits\MigrationCommand;

/**
 * EloquentUnitServiceProvider
 *
 */ 

class EloquentUnitServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
    * Bootstrap the application.
    *
    * @return void
    */
    public function boot()
    {
        // The publication files to publish
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('units.php'),
            __DIR__ . '/../../views' => base_path('resources/views/vendor/microffice/eloquent-units'),
        ]);

        // Append the units settings
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'units');

        // Register commands
        $this->commands('command.eloquent-units.migration');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../../views', 'eloquent-units');
    }
        
    /**
     * Register everything.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.eloquent-units.migration', function ($app) {
            return new MigrationCommand();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        //return ['Microffice\Units\EloquentUnitServiceProvider'];
        //return ['unit'];
        return ['command.eloquent-units.migration'];
    }
}