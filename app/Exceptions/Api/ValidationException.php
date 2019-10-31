<?php

namespace App\Exceptions\Api;

use Exception;

class ValidationException extends Exception
{
    public function __construct($message = "")
    {
        parent::__construct($message, 400);
    }
}
