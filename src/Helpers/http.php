<?php

/**
 * @copyright  Copyright (c) 2015-2022 Vallabh Kansagara <vrkansagara@gmail.com>
 * @license    https://opensource.org/licenses/BSD-3-Clause New BSD License
 */

/**
 * Helper file
 */

if (! function_exists('errorCode')) {
    /**
     * errorCode
     * This would be used for mobile application.
     * Custom error code for mobile and web.
     *
     * 100 - 199
     * 200 - 299
     * 300 - 399
     * 400 - 499
     * 500 - 599
     *
     * @return mixed
     */
    function errorCode(int $code): string
    {
        $statusCode = [
            401 => 'Unauthenticated',
        ];

        return $statusCode[$code];
    }
}
