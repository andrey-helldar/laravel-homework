<?php

app('router')
    ->get('{slug?}', 'IndexController@index')
    ->where('slug', '.*')
    ->name('index');
