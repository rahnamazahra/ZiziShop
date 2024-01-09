<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Notifications\Channels\SmsChannel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind('path.public', function() {
        //     return base_path('../public');
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       $this->app->when(SmsChannel::class)
        ->give(function () {
            return new SmsChannel();
        });

    }
}
