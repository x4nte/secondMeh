<?php

namespace App\Helpers;

class Config
{

    private static array $loadedConfigs = [];

    public static function hasConfig(string $filePath): bool
    {
        return isset(self::$loadedConfigs[$filePath]);
    }

    public static function get($key, $default = null): ?string
    {
        $keyExploded = explode('.', $key);
        $path = APP_PATH . "config/" . $keyExploded[0] . ".php";

        if (self::hasConfig($path)) {
            return self::$loadedConfigs[$path][$keyExploded[1]] ?? $default;
        }

        $config = require($path);
        self::$loadedConfigs[$path] = $config;
        return $config[$keyExploded[1]] ?? $default;
    }

}