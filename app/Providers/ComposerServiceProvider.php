<?php

namespace App\Providers;

use App\Http\ViewComposers\WeatherViewComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('components._weather', WeatherViewComposer::class);
    }
}
