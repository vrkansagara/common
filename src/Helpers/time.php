<?php

declare(strict_types=1);

if (! function_exists('hourMin')) {
    function hourMin(int|string $minutes = 0): string
    {
        $returnData = '00h 00m';
        if ($minutes) {
            $returnData = sprintf(
                "%02d",
                floor($minutes / 60)
            ) . 'h '
                . sprintf(
                    "%02d",
                    str_pad(
                        $minutes % 60,
                        2,
                        "0",
                        STR_PAD_LEFT
                    )
                ) . "m";
        }

        return $returnData;
    }
}
