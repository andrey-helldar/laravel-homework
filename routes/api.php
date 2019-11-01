<?php

app('router')
    ->get('weather', 'Api\WeatherController@get')
    ->name('weather');

app('router')
    ->apiResource('orders', 'Api\OrdersController');

app('router')
    ->any('{slug?}', 'IndexController@abort')
    ->where('slug', '.*')
    ->name('abort');
