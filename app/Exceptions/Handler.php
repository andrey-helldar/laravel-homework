<?php

namespace App\Exceptions;

use Helldar\ApiResponse\Exceptions\Laravel\Eight\ApiHandler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
}
