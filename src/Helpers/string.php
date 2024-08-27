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

if (! function_exists('isValidJson')) {
    function isValidJson(string $string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}

if (! function_exists('generateRandomString')) {
    /**
     * Generate random string.
     */
    function generateRandomString(int $length = 32): string
    {
        // Alphabets (Capitals & Smalls), numeric values and special characters should be there
        $capital           = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 1);
        $small             = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 1);
        $number            = substr(str_shuffle('0123456789'), 0, 1);
        $specialCharacters = substr(str_shuffle("!#$%&*-@_"), 0, 1);
        $pool              = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!#$%&*-@_';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length - 2)
            . $capital
            . $small
            . $number
            . $specialCharacters;
    }
}
