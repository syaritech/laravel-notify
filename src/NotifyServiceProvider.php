<?php

namespace Syaritech\Notify;

use Illuminate\Support\ServiceProvider;
use Syaritech\Notify\Facades\Notify;

/**
 *
 */
class NotifyServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/notify.php', 'notify');

        $this->app->bind('notify', function ($app) {
            return new Notify();
        });
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config/notify.php' => config_path('notify.php'),
            ], 'config');

        }
    }
}