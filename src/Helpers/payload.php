<?php

/**
 * @copyright  Copyright (c) 2015-2022 Vallabh Kansagara <vrkansagara@gmail.com>
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 */

/**
 * Helper file
 */

if (! function_exists('getSize')) {
    /**
     * @param array $payLoad
     * @param string $sizeType
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
