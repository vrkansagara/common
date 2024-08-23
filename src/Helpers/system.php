<?php

declare(strict_types=1);

if (! function_exists('numCpus')) {
    /**
     * Returns the number of available CPU cores
     *
     *  Should work for Linux, Windows, Mac & BSD
     *
     * @return integer
     */
    function numCpus()
    {
        $numCpus = 1;

        if (is_file('/proc/cpuinfo')) {
            $cpuinfo = file_get_contents('/proc/cpuinfo');
            preg_match_all('/^processor/m', $cpuinfo, $matches);

            $numCpus = count($matches[0]);
        } elseif ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
            $process = @popen('wmic cpu get NumberOfCores', 'rb');

            if (false !== $process) {
                fgets($process);
                $numCpus = intval(fgets($process));

                pclose($process);
            }
        } else {
            $process = @popen('sysctl -a', 'rb');

            if (false !== $process) {
                $output = stream_get_contents($process);

                preg_match('/hw.ncpu: (\d+)/', $output, $matches);
                if ($matches) {
                    $numCpus = intval($matches[1][0]);
                }

                pclose($process);
            }
        }

        return $numCpus;
    }
}

if (! function_exists('getCurrentMemoryUsage')) {
    /**
     * @usage echo getCurrentMemoryUsage(memory_get_usage(true)); // 123 kb
     */
    function getCurrentMemoryUsage(int $size): string
    {
        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
        return @round($size / pow(1024, $i = floor(log($size, 1024))), 2) . ' ' . $unit[$i];
    }
}
