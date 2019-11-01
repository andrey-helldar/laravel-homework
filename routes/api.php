<?php

app('router')
    ->get('weather', 'Api\WeatherController@get')
    ->name('weather');

app('router')->apiResource('orders', 'Api\OrdersController');
app('router')->apiResource('partners', 'Api\PartnersController');
app('router')->apiResource('products', 'Api\ProductsController');
app('router')->apiResource('vendors', 'Api\VendorsController');

app('router')
    ->any('{slug?}', 'IndexController@abort')
    ->where('slug', '.*')
    ->name('abort');
