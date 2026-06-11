<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
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

        // Provide the live cart to the mini-cart offcanvas on every page (guest or user).
        View::composer('layouts.site.cart-mini', function ($view) {
            $view->with('cart', \App\Models\Cart::existing());
        });

    }
}
