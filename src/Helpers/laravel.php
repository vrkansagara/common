<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

if (! function_exists('lIsProductionEnvironment')) {
    function lIsProductionEnvironment()
    {
        return in_array(app()->environment(), ['prod', 'production']) ? true : false;
    }
}

if (! function_exists('lD')) {
    function lD(...$vars)
    {
        $debug = debug_backtrace()[0];
        foreach ($vars as $v) {
            echo '<br>';
        }
        echo '<hr>';
        echo sprintf('%s ', $debug['file']) . PHP_EOL;
        echo sprintf('%d ', $debug['line']) . PHP_EOL;
    }
}

if (! function_exists('lIsMobileRequest')) {
    /**
     * Check weather request belongs to the mobile request
     *
     * @return bool
     */
    function lIsMobileRequest(Request $request)
    {
        $platform = $request->header('Platform');

        if (in_array($platform, ['android', 'ios'])) {
            return true;
        }
        return false;
    }
}

if (! function_exists('lConvertApiDropDown')) {
    /**
     * This function convert to SPI like dropdown
     *
     * @param $data
     * @param $keyName
     * @param $valueName
     * @param array $extra
     * @return array
     */
    function lConvertApiDropDown($data, string $keyName = 'id', string $valueName = 'name', array $extra = []): array
    {
        if ($data instanceof Collection) {
            $data = $data->toArray();
        }
        if (! is_array($data)) {
            return [];
        }
        $finalArray = [];
        foreach ($data as $index => $value) {
            $array             = [];
            $array[$keyName]   = $index;
            $array[$valueName] = $value;
            if (is_array($extra) && ! empty($extra)) {
                foreach ($extra as $extraKey => $values) {
                    $array[$extraKey] = $values[$index] ?? null;
                }
            }
            $finalArray[] = $array;
        }
        return $finalArray;
    }
}
