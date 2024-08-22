<?php

/**
 * @copyright  Copyright (c) 2015-2022 Vallabh Kansagara <vrkansagara@gmail.com>
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 */

/**
 * Helper file
 */
if (! function_exists('validate_ip')) {
    /**
     * Ensures an ip address is both a valid IP and does not fall within a private network range.
     *
     * @param string $ip
     * @return bool
     */
    function validate_ip(string $ip): bool
    {
        if (strtolower($ip) === 'unknown') {
            return false;
        }

        // generate ipv4 network address
        $ip = ip2long($ip);

        // if the ip is set and not equivalent to 255.255.255.255
        if ($ip !== false && $ip !== -1) {
            // make sure to get unsigned long representation of ip
            // due to discrepancies between 32 and 64 bit OSes and
            // signed numbers (ints default to signed in PHP)
            $ip = sprintf('%u', $ip);
            // do private network range checking
            if ($ip >= 0 && $ip <= 50331647) {
                return false;
            }
            if ($ip >= 167772160 && $ip <= 184549375) {
                return false;
            }
            if ($ip >= 2130706432 && $ip <= 2147483647) {
                return false;
            }
            if ($ip >= 2851995648 && $ip <= 2852061183) {
                return false;
            }
            if ($ip >= 2886729728 && $ip <= 2887778303) {
                return false;
            }
            if ($ip >= 3221225984 && $ip <= 3221226239) {
                return false;
            }
            if ($ip >= 3232235520 && $ip <= 3232301055) {
                return false;
            }
            if ($ip >= 4294967040) {
                return false;
            }
        }
        return true;
    }
}
if (! function_exists('getIpecho')) {
    function getIpecho(): string
    {
        return @file_get_contents('http://ipecho.net/plain/');
    }
}

if (! function_exists('getIpInfo')) {
    /**
     * @param string $token
     * @param string $ip
     * @return string|null
     */
    function getIpInfo(string $token, string $ip = ''): string|null
    {
        $returnResponse = null;
        if (! empty($ip) && validate_ip($ip)) {
            $curl = sprintf("https://ipinfo.io/%s?token=%s", $ip, $token);
            $returnResponse = @json_decode(file_get_contents($curl, false, stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => [
                        'Accept: application/json',
                    ],
                ],
            ])), true);
        }
        return $returnResponse;
    }
}
