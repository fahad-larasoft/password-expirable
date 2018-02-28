<?php

namespace Larasoft\PasswordExpiry;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Larasoft\PasswordExpiry\Console\Commands\CheckPasswordExpiry;
use Schuppo\PasswordStrength\PasswordStrengthServiceProvider;

class PasswordExpiryServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/passwordExpiry.php' => config_path('passwordExpiry.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                CheckPasswordExpiry::class
            ]);
        }

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('check:password-expiry')->everyMinute();
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('CustomDateFormatterFacade', CustomDateFormatter::class );

        $this->mergeConfigFrom(
            __DIR__.'/../config/passwordExpiry.php', 'passwordExpiry'
        );

        $this->app->register(PasswordStrengthServiceProvider::class);
    }
}