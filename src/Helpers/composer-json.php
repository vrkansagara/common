<?php

declare(strict_types=1);

if (! function_exists('getComposerDetails')) {
    function getComposerDetails(string $composerJsonFilePath, array $composerDetails = ['require']): string
    {
        $restunData = null;
        if (is_readable($composerJsonFilePath)) {
            $composerDetails = json_decode(file_get_contents($composerJsonFilePath), true);
            $data            = array_keys($composerDetails);
            ksort($data);
            $restunData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        return $restunData;
    }
}
