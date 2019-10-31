<?php

namespace App\Validators;

use App\Exceptions\Api\ValidationException;
use App\Rules\Api\Math\IsDouble;
use App\Rules\Api\Weather\CheckLanguage;
use Illuminate\Support\Facades\Validator;

class WeatherValidator
{
    /**
     * @param array $params
     *
     * @throws \App\Exceptions\Api\ValidationException
     */
    public function check(array $params)
    {
        $validator = Validator::make($params, $this->rules());

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->first());
        }
    }

    private function rules(): array
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
