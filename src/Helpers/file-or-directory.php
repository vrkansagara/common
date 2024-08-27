<?php

declare(strict_types=1);

if (! function_exists('includeFiles')) {
    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @example
     * $localDirectory = __DIR__ . '/local/';
     * if (is_dir($localDirectory)) {
     * includeRouteFiles($localDirectory);
     * }
     */
    function includeFiles(string $folder): void
    {
        $directory     = $folder;
        $handle        = opendir($directory);
        $directoryList = [$directory];

        while (false !== ($filename = readdir($handle))) {
            if ($filename !== '.' && $filename !== '..' && is_dir($directory . $filename)) {
                array_push($directoryList, $directory . $filename . '/');
            }
        }

        foreach ($directoryList as $directory) {
            foreach (glob($directory . '*.php') as $filename) {
                include $filename;
            }
        }
    }
}

if (! function_exists('copyFiles')) {
    /**
     * Copy all files recursively from source to destination
     */
    function copyFiles(string $source, string $dest): bool
    {
        if (! file_exists($source)) {
            return false;
        }
        if (! file_exists($dest)) {
            mkdir($dest);
        }
        /** @var RecursiveIteratorIterator $iterator */
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($iterator as $item) {
            $destName = $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
            if ($item->isDir()) {
                if (! file_exists($destName)) {
                    if (! @mkdir($destName)) {
                        return false;
                    }
                }
            } else {
                if (! @copy($item, $destName)) {
                    return false;
                }
                chmod($destName, fileperms($item));
            }
        }
        return true;
    }
}

if (! function_exists('deleteFolder')) {
    function deleteFolder(string $source): bool
    {
        if (! file_exists($source)) {
            return false;
        }
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($iterator as $item) {
            if ($item->isDir()) {
                if (! @rmdir($item->getRealPath())) {
                    return false;
                }
            } else {
                if (! @unlink($item->getRealPath())) {
                    return false;
                }
            }
        }
        return @rmdir($source);
    }
}

if (! function_exists('deleteFilesFromFolder')) {
    /**
     * @param array $extentions
     */
    function deleteFilesFromFolder(string $source, array $extentions = []): bool
    {
        if (empty($extentions) || ! file_exists($source)) {
            return false;
        }
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        /** @var SplFileInfo $item */
        foreach ($iterator as $item) {
            $filetype = strtolower(pathinfo($item, PATHINFO_EXTENSION));
            if (in_array($filetype, $extentions)) {
                @unlink($item->getPathname());
            }
        }
        return true;
    }
}
