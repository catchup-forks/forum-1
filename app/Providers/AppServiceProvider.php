<?php

namespace App\Providers;

use App\User;
use App\Channel;
use App\Workout;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
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

        Validator::extend('unrealistic_tempo', function ($attribute, $value, $parameters, $validator) {
            return $value > 149;
        });

        Validator::extend('not_attending_workout', function ($attribute, $value, $parameters, $validator) {

            $user_id = $parameters[0];
            $user = User::find($user_id);

            $plus2hours = date('Y-m-d H:i:s', strtotime($value . ' + 2 hours'));
            $minus2hours = date('Y-m-d H:i:s', strtotime($value . ' - 2 hours'));

            $otherWorkouts = Workout::where('user_id', $user_id)->where('starting', '<=', $plus2hours)->where('starting', '>=', $minus2hours)->get();

            if ($user != null) {
                $attendingWorkouts = $user->workouts()->where('starting', '<=', $plus2hours)->where('starting', '>=', $minus2hours)->get();
            } else {
                $attendingWorkouts = [];
            }

            return count($otherWorkouts) === 0 && count($attendingWorkouts) === 0;
        });

        View::composer('*', function ($view) {
            $channels = Cache::rememberForever('channels', function () {
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
