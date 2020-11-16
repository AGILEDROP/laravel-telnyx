<?php

namespace AGILEDROP\LaravelTelnyx;

use Illuminate\Notifications\ChannelManager;
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
            $service->extend('telnyx-sms', function ($app) {
                return new Channels\SmsChannel(
                    config('laravel-telnyx.messaging_profile_id'),
                    config('laravel-telnyx.from')
                );
            });
            $service->extend('telnyx-mms', function ($app) {
                return new Channels\MmsChannel(
                    config('laravel-telnyx.messaging_profile_id'),
                    config('laravel-telnyx.from')
                );
            });
        });
    }
}
