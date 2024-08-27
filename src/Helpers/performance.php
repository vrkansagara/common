<?php

declare(strict_types=1);

if (! function_exists('getRequestExecutionTime')) {
    function getRequestExecutionTime(int $startMicroTime, int $endMicroTime): string
    {
        $time = $startMicroTime - $endMicroTime;

        // formatting time to be more friendly
        if ($time <= 60) {
            $timeF = number_format($time, 2, ',', '.') . 's'; // conversion to seconds
        } else {
            $resto  = fmod($time, 60);
            $minuto = number_format($time / 60, 0);
            $timeF  = sprintf('%dm%02ds', $minuto, $resto); // conversion to minutes and seconds
        }

        return $timeF;
    }
}
