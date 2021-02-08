<?php

namespace App\Rules\Api\Weather;

use App\Constants\Weather;
use Illuminate\Contracts\Validation\Rule;

use function implode;
use function in_array;

class CheckLanguage implements Rule
{
    public function passes($attribute, $value): bool
    {
        return in_array($value, Weather::LANGUAGES);
    }

    public function message(): string
    {
        $languages = $this->getLanguages();

        return 'The language must be one of: ' . $languages;
    }

    protected function getLanguages(): string
    {
        return implode(', ', Weather::LANGUAGES);
    }
}
