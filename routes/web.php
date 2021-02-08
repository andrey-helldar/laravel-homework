<?php

use App\Http\Controllers\IndexController;

app('router')
    ->get('{slug?}', [IndexController::class, 'index'])
    ->name('index');
