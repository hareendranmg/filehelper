<?php

namespace Keltron\Filehelper;

use Illuminate\Support\ServiceProvider;

class FilehelperServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'keltron');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'keltron');
        // ╰─ php artisan vendor:publish --tag=public --force                                                                                                                           ─╯
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        $this->publishes([
            __DIR__ . '/public' => public_path('keltron/filehelper'),
        ], 'public');
        
        if (!class_exists('CreateFilehelperTable')) {
            $this->publishes([
                __DIR__ . '/database/migrations/2021_09_13_055730_create_filehelper_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_filehelper_table.php'),
                // you can add any number of migrations here
            ], 'migrations');
        }

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/filehelper.php', 'filehelper');
        // ╰─ php artisan vendor:publish --tag=filehelper.config --force                                                                                                                ─╯

        // Register the service the package provides.
        $this->app->singleton('filehelper', function ($app) {
            return new Filehelper;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['filehelper'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/config/filehelper.php' => config_path('filehelper.php'),
        ], 'filehelper.config');

        // Publishing the views.
        /*$this->publishes([
        __DIR__.'/../resources/views' => base_path('resources/views/vendor/keltron'),
        ], 'filehelper.views');*/

        // Publishing assets.
        /*$this->publishes([
        __DIR__.'/../resources/assets' => public_path('vendor/keltron'),
        ], 'filehelper.views');*/

        // Publishing the translation files.
        /*$this->publishes([
        __DIR__.'/../resources/lang' => resource_path('lang/vendor/keltron'),
        ], 'filehelper.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
