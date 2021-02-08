<?php

if (! function_exists('price_format')) {
    function price_format(string|float|int $value, string $separator = '&nbsp;'): string
    {
        return number_format($value, 0, '.', $separator);
    }
}
