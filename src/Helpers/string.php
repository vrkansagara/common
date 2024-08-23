<?php

declare(strict_types=1);

if (! function_exists('getStringBetween')) {
    /**
     * @@example
     * $fullstring = 'this is my [tag]dog[/tag]';
     * $parsed = get_string_between($fullstring, '[tag]', '[/tag]');
     * @return string
     */
    function getStringBetween(string $string, string $start, string $end)
    {
        $string = ' ' . $string;
        $ini    = strpos($string, $start);
        if ($ini === 0) {
            return '';
        }
        $ini += strlen($start);
        $len  = strpos($string, $end, $ini) - $ini;
        return trim(substr($string, $ini, $len));
    }
}

if (! function_exists('stringToSecret')) {
    /**
     * @param string|NULL $string
     * @return string|null
     * @example
     * 1 => 1
     * 12 => 12
     * 123 => 1*3
     * 1234 => 1**4
     * 12345 => 1***5
     * 123456 => 12**56
     * 1234567 => 12***67
     * 12345678 => 12****78
     */
    function stringToSecret(?string $string = null)
    {
        if (! $string) {
            return null;
        }
        $length       = strlen($string);
        $visibleCount = (int) round($length / 4);
        $hiddenCount  = $length - ($visibleCount * 2);
        return substr($string, 0, $visibleCount)
            . str_repeat('*', $hiddenCount)
            . substr($string, $visibleCount * -1, $visibleCount);
    }
}
