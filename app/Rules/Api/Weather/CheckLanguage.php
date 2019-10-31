<?php

namespace App\Rules\Api\Weather;

use App\Constants\Weather;
use Illuminate\Contracts\Validation\Rule;

use function implode;
use function in_array;

class CheckLanguage implements Rule
{
    public function passes($attribute, $value)
    {
        return in_array($value, Weather::LANGUAGES);
    }

    public function message()
    {
        $languages = $this->getLanguages();

        return 'The language must be one of: ' . $languages;
    }

    private function getLanguages(): string
    {
        return implode(', ', Weather::LANGUAGES);
    }
}
