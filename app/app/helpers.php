<?php


use App\Helpers\Config as ConfigAlias;

function config($key, $default = null) : ?string
{
    return ConfigAlias::get($key, $default);
}

if (!function_exists('base_path')) {
    function base_path($path = '') {
        return APP_PATH . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }
}