<?php

if (! function_exists('price_format')) {
    /**
     * @param mixed $value
     * @param string $thousands_sep
     *
     * @return string
     */
    function price_format($value, string $thousands_sep = '&nbsp;'): string
    {
        return number_format($value, 0, '.', $thousands_sep);
    }
}
