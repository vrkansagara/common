<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

if (! function_exists('lIsProductionEnvironment')) {
    function lIsProductionEnvironment(): bool
    {
        return in_array(app()->environment(), ['prod', 'production']) ? true : false;
    }
}

if (! function_exists('lD')) {
    /**
     * @param array ...$vars
     */
    function lD(array ...$vars): void
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
     * @param mixed $data
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

if (! function_exists('cronLog')) {
    /**
     * Lets store cron logging in database
     *
     * @param array $options
     * @throws Exception
     */
    function cronLog(string $signature, int $isStart = 1, array $options = []): void
    {
        try {
            DB::beginTransaction();
            $data = ['name' => $signature];
            $now  = Carbon::now();
            if ($isStart) {
                $data['start'] = $now;
                if (isset($options['created_at'])) {
                    $data['created_at'] = $options['created_at'];
                }
                DB::table('cron_log')->insert($data);
            } else {
                $data['end'] = $now;
                DB::table('cron_log')
                    ->where('name', '=', $signature)
                    ->orderByDesc('id')
                    ->limit(1)
                    ->update($data);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
