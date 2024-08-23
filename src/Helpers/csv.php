<?php

declare(strict_types=1);

if (! function_exists('csvToArray')) {
    /**
     * @return array
     */
    function csvToArray(string $filename = '', string $delimiter = ','): array
    {
        $header = null;
        $data   = [];

        if (! file_exists($filename) || ! is_readable($filename)) {
            return $data;
        }

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (! $header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }
}
