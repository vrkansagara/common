<?php

declare(strict_types=1);

if (! function_exists('setProductionIni')) {
    function setProductionIni(array $configSet = []): void
    {
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
        ini_set('display_errors', '0');
        ini_set("display_startup_errors", '0');
        ini_set("log_errors", '1');
    }
}

if (! function_exists('setDevelopmentIni')) {
    function setDevelopmentIni(array $configSet = []): void
    {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        ini_set("display_startup_errors", '1');
        ini_set("log_errors", '0');
    }
}
