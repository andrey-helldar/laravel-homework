<?php

use App\Http\Controllers\Api\{OrderController, PartnerController, ProductController, VendorController, WeatherController};
use App\Http\Controllers\IndexController;

app('router')
    ->get('weather', [WeatherController::class, 'get'])
    ->name('weather');

app('router')->apiResource('orders', OrderController::class);
app('router')->apiResource('partners', PartnerController::class);
app('router')->apiResource('products', ProductController::class);
app('router')->apiResource('vendors', VendorController::class);

app('router')
    ->any('{slug?}', [IndexController::class, 'abort'])
    ->name('abort');
