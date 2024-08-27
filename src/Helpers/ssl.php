<?php

declare(strict_types=1);

if (! function_exists('generateRsaEncryption')) {
    function generateRsaEncryption(string $string, string $publicKeyPath): string
    {
        $fp     = fopen($publicKeyPath, 'r');
        $pubKey = fread($fp, 8192);
        fclose($fp);
        openssl_public_encrypt($string, $crypttext, $pubKey);
        return base64_encode($crypttext);
    }
}

if (! function_exists('generateAesEncryption')) {
    function generateAesEncryption(string $string, string $keyString, int $isDecrypt = 0): string
    {
        /**
         * CBC has an IV and thus needs randomness every time a message is encrypted
         * openssl_get_cipher_methods($method)
         * // Most secure key
         * $key = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
         */
        $method = 'aes-256-ecb';
        $ivlen  = openssl_cipher_iv_length($method);
        // Most secure iv Never ever use iv=0 in real live. Better use this:
        $iv     = openssl_random_pseudo_bytes($ivlen);
        $string = base64_encode(openssl_encrypt($string, $method, $keyString, OPENSSL_RAW_DATA, $iv));
        if ($isDecrypt) {
            $string = openssl_decrypt(base64_decode($string), $method, $keyString, OPENSSL_RAW_DATA, $iv);
        }
        return $string;
    }
}
