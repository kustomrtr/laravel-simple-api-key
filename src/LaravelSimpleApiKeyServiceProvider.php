<?php

namespace Kustomrt\LaravelSimpleApiKey;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Kustomrt\LaravelSimpleApiKey\Http\Middleware\LaravelSimpleApiKeyMiddleware;

class LaravelSimpleApiKeyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-simple-api-key');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-simple-api-key');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-simple-api-key.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-simple-api-key'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-simple-api-key'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-simple-api-key'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('auth.apikey', LaravelSimpleApiKeyMiddleware::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-simple-api-key');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-simple-api-key', function () {
            return new LaravelSimpleApiKey;
        });

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('SimpleApiKey', "Kustomrt\\LaravelSimpleApiKey\\LaravelSimpleApiKeyFacade");
    }
}
