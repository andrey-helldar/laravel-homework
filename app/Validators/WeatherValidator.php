<?php

namespace App\Validators;

use App\Rules\Api\Math\IsDouble;
use App\Rules\Api\Weather\CheckLanguage;
use Illuminate\Support\Facades\Validator;

class WeatherValidator
{
    public function check(array $params)
    {
        Validator::make($params, $this->rules())->validate();
    }

    protected function rules(): array
    {
        return [
            'lat'   => ['required', new IsDouble()],
            'lon'   => ['required', new IsDouble()],
            'lang'  => ['nullable', new CheckLanguage()],
            'limit' => ['nullable', 'integer', 'min:1'],
            'hours' => ['nullable', 'boolean'],
            'extra' => ['nullable', 'boolean'],
        ];
    }
}
