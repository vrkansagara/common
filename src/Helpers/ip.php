<?php

declare(strict_types=1);

if (! function_exists('isValidIp')) {
    /**
     * Ensures an ip address is both a valid IP and does not fall within a private network range.
     */
    function isValidIp(string $ip): bool
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
    function getIpInfo(string $token, string $ip = ''): string|null
    {
        $returnResponse = null;
        if (! empty($ip) && validate_ip($ip)) {
            $curl           = sprintf("https://ipinfo.io/%s?token=%s", $ip, $token);
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

if (! function_exists('getIpAddress')) {
    /**
     * Retrieves the best guess of the client's actual IP address.
     * Takes into account numerous HTTP proxy headers due to variations
     * in how different ISPs handle IP addresses in headers between hops.
     */
    function getIpAddress(): string
    {
        // check for shared internet/ISP IP
        if (! empty($_SERVER['HTTP_CLIENT_IP']) && isValidIp($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        // check for IPs passing through proxies
        if (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check if multiple ips exist in var
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
                $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($iplist as $ip) {
                    if (isValidIp($ip)) {
                        return $ip;
                    }
                }
            } else {
                if (isValidIp($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    return $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
            }
        }
        if (! empty($_SERVER['HTTP_X_FORWARDED']) && isValidIp($_SERVER['HTTP_X_FORWARDED'])) {
            return $_SERVER['HTTP_X_FORWARDED'];
        }
        if (! empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && isValidIp($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        }
        if (! empty($_SERVER['HTTP_FORWARDED_FOR']) && isValidIp($_SERVER['HTTP_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        }
        if (! empty($_SERVER['HTTP_FORWARDED']) && isValidIp($_SERVER['HTTP_FORWARDED'])) {
            return $_SERVER['HTTP_FORWARDED'];
        }
        // return unreliable ip since all else failed
        return $_SERVER['REMOTE_ADDR'];
    }
}
