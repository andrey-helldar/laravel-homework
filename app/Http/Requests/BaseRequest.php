<?php

namespace App\Http\Requests;

use Helldar\LaravelSupport\Traits\InitModelHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

abstract class BaseRequest extends FormRequest
{
    use InitModelHelper;

    protected function getUnique(string $model): Unique
    {
        $table = $this->model()->table($model);

        if ($id = $this->request->get('id')) {
            return Rule::unique($table)->ignore($id);
        }

        return Rule::unique($table);
    }
}
