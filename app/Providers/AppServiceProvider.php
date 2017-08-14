<?php

namespace App\Providers;

use App\Channel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        \View::composer('*', function($view){
            $channels = Cache::rememberForever('channels', function() {
                return Channel::all();
            });
            $view->with('channels', $channels);
        });

        Carbon::setLocale(env('LOCALE', 'en'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->isLocal()) {
            app()->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
