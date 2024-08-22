<?php

declare(strict_types=1);

if (! function_exists('getSize')) {
    /**
     * @param array $payLoad
     * @param array $options
     * @return int|void
     */
    function getSize(array $payLoad = [], string $sizeType = 'kb', array $options = []): int
    {
        if (isset($payLoad['data']) && ! is_bool($payLoad['data'])) {
            return sizeof($payLoad['data']);
        }
        return 0;
    }
}
