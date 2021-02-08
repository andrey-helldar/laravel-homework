<?php

namespace App\Rules\Api\Math;

use Illuminate\Contracts\Validation\Rule;

use function fmod;
use function is_double;
use function is_float;
use function is_numeric;

class IsDouble implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (! is_numeric($value)) {
            return false;
        }

        $value = fmod($value, 1);

        return is_double($value) || is_float($value);
    }

    public function message(): string
    {
        return 'The number in :attribute field must be fractional.';
    }
}
