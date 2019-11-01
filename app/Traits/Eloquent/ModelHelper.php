<?php

namespace App\Traits\Eloquent;

use Helldar\Support\Laravel\Models\ModelHelper as ModelHelperService;

trait ModelHelper
{
    final protected function helper(): ModelHelperService
    {
        return new ModelHelperService();
    }
}
