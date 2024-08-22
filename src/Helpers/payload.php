<?php

declare(strict_types=1);

if (! function_exists('getSize')) {
    /**
     * @param array $payLoad
     * @param array $options
     */
    function getSize(array $payLoad = [], string $sizeType = 'kb', array $options = []): int
    {
        if (isset($payLoad['data']) && ! is_bool($payLoad['data'])) {
            return count($payLoad['data']);
        }
        return 0;
    }
}
