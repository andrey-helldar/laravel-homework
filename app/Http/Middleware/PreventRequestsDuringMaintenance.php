<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

final class PreventRequestsDuringMaintenance extends Middleware
{
    protected $except = [
        //
    ];
}
