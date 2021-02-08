<?php

use App\Services\WeatherService;
use Illuminate\Support\Facades\Artisan;

Artisan::command('foo', function (WeatherService $weather) {
    dd(
        $weather->get()
    );
});
