<?php

namespace App\Traits;

use Helldar\Support\Laravel\Models\ModelHelper as ModelHelperSupport;

trait ModelHelper
{
    /**
     * @param string $model
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return string
     */
    protected function getTable(string $model): string
    {
        $helper = new ModelHelperSupport();

        return $helper->table($model);
    }
}
