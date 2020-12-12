<?php

namespace Savannabits\Koaladmin;

use Illuminate\Support\ServiceProvider;
use Savannabits\Koaladmin\Helpers\KoalaHelper;

class KoaladminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'koaladmin');
         $this->loadViewsFrom(__DIR__.'/../resources/views', 'koala');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        if (file_exists(base_path('routes/koaladmin.php'))) {

            $this->loadRoutesFrom(base_path('routes/koaladmin.php'));
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/koaladmin.php' => config_path('koaladmin.php'),
                __DIR__.'/../config/scout.php' => config_path('scout.php'),
            ], 'koala-config');

            $this->publishes([
                __DIR__.'/../publishes/koala_menu.json' => base_path('koala_menu.json'),
            ], 'koala-menu');

            $this->publishes([
                __DIR__.'/../publishes/storage/search-index' => storage_path('search-index'),
            ], 'koala-search-index-dir');

            $this->publishes([
                __DIR__.'/../publishes/routes/koaladmin.php' => base_path('routes/koaladmin.php'),
            ], 'koala-routes');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../publishes/views/koaladmin' => resource_path('views/koaladmin'),
                __DIR__.'/../publishes/views/layouts' => resource_path('views/layouts'),
            ], 'koala-views');

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/koaladmin'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/koaladmin'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
            $this->commands([
                Koaladmin::class,
                Generators\Model::class,
                Generators\ApiController::class,
                Generators\Controller::class,
                Generators\ViewIndex::class,
                Generators\ViewForm::class,
                Generators\ViewFullForm::class,
                Generators\ModelFactory::class,
                Generators\Routes::class,
                Generators\ApiRoutes::class,
                Generators\IndexRequest::class,
                Generators\StoreRequest::class,
                Generators\UpdateRequest::class,
                Generators\DestroyRequest::class,
                Generators\ImpersonalLoginRequest::class,
                Generators\BulkDestroyRequest::class,
                Generators\Lang::class,
                Generators\Permissions::class,
                Generators\Export::class,
            ]);

        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/koaladmin.php', 'koaladmin');
        $this->mergeConfigFrom(__DIR__.'/../config/scout.php', 'scout');

        // Register the main class to use with the facade
        $this->app->singleton('koaladmin', function () {
            return new Koaladmin;
        });
    }
}
