<?php

namespace MakeUser\Providers;

use MakeUser\Console\Commands\MakeUser;
use Illuminate\Support\ServiceProvider;

class MakeUserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register command.
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeUser::class,
            ]);
        }

        // Publish vendor files (config, translations).
        $this->publishes([
            __DIR__ . '/../config/make_user.php' => config_path('make_user.php'),
            __DIR__ . '/../resources/lang' => resource_path('lang'),
        ], 'make_user');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
