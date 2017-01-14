<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.single', function ($view) {
            $events = Event::whereIn('status', ['announced', 'published'])->orderBy('status', 'start')->get();
            $view->with('events', $events);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
