<?php

namespace App\Providers;

use Helldar\ApiResponse\Services\Response;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        Response::withoutWrap();
    }
}
