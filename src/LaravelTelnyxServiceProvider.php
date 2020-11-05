<?php

namespace AGILEDROP\LaravelTelnyx;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Notifications\Channels\TelnyxSmsChannel;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class LaravelTelnyxServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-telnyx.php' => config_path('laravel-telnyx.php'),
            ], 'config');

            /*$this->commands([
                LaravelTelnyxCommand::class,
            ]);*/
        }

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-telnyx.php', 'laravel-telnyx');

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('telnyx', function ($app) {
                return new TelnyxSmsChannel(
                    config('laravel-telnyx.messaging_profile_id'),
                    config('laravel-telnyx.from')
                );
            });
        });
    }
}
